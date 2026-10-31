<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EnquiryController extends Controller
{
    // ---------- General enquiry (contact page) ----------

    public function contact()
    {
        return view('enquiries.contact');
    }

    public function storeContact(Request $request): RedirectResponse
    {
        // A hidden "honeypot" field: real people never fill it in, bots usually do.
        abort_if(filled($request->input('website')), 422);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $enquiry = Enquiry::create($data + [
            'type' => 'general',
            'reference' => $this->newReference(),
        ]);

        return redirect()->route('contact.create')
            ->with('status', 'Thank you, your message has been received. Reference: ' . $enquiry->reference);
    }

    // ---------- Project enquiry (request a quote) ----------

    public function quote()
    {
        return view('enquiries.quote');
    }

    public function storeQuote(Request $request): RedirectResponse
    {
        abort_if(filled($request->input('website')), 422);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:150'],
            'client_type' => ['nullable', Rule::in(config('enquiry.client_types'))],
            'project_name' => ['required', 'string', 'max:150'],
            'project_type' => ['required', Rule::in(config('enquiry.project_types'))],
            'location' => ['nullable', 'string', 'max:150'],
            'services' => ['required', 'array', 'min:1'],
            'services.*' => [Rule::in(config('enquiry.services'))],
            'message' => ['required', 'string', 'max:5000'],
            'deadline' => ['nullable', Rule::in(config('enquiry.deadlines'))],
            'budget' => ['nullable', Rule::in(config('enquiry.budgets'))],
            'files' => ['nullable', 'array', 'max:10'],
            'files.*' => ['file', 'extensions:' . implode(',', config('enquiry.file_extensions')), 'max:51200'],
            'confirm' => ['accepted'],
        ]);

        $enquiry = DB::transaction(function () use ($request, $data) {
            $enquiry = Enquiry::create(
                Arr::except($data, ['files', 'confirm']) + [
                    'type' => 'project',
                    'reference' => $this->newReference(),
                ]
            );

            foreach ($request->file('files', []) as $file) {
                $size = $file->getSize();
                $original = Str::limit($file->getClientOriginalName(), 200, '');

                // Files go to the private disk, with a random name. They have no public address.
                $path = $file->storeAs(
                    'enquiries/' . $enquiry->reference,
                    Str::uuid() . '.' . strtolower($file->getClientOriginalExtension()),
                    'local'
                );

                $enquiry->files()->create([
                    'original_name' => $original,
                    'path' => $path,
                    'size_bytes' => $size,
                ]);
            }

            return $enquiry;
        });

        return redirect()->route('quote.thanks')->with('reference', $enquiry->reference);
    }

    public function thanks(Request $request)
    {
        $reference = $request->session()->get('reference');

        if (! $reference) {
            return redirect()->route('quote.create');
        }

        return view('enquiries.thanks', compact('reference'));
    }

    private function newReference(): string
    {
        return 'BP-' . now()->format('Y') . '-' . strtoupper(Str::random(6));
    }
}