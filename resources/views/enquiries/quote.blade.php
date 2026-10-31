@extends('layouts.app')

@section('title', 'Request a quote | BIM PORTAL')

@section('content')
    @php
        $input = 'mt-2 block w-full rounded-md border border-line bg-white px-4 py-3 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30';
        $label = 'block text-xs font-semibold uppercase tracking-wider text-muted';
        $stepNames = ['Your details', 'Project', 'Services', 'Files and timing'];
    @endphp

    <section class="relative isolate overflow-hidden bg-navy-950 py-16 sm:py-20">
        <div class="absolute inset-0 -z-10 bg-blueprint opacity-20"></div>
        <div class="absolute -right-24 top-0 -z-10 h-80 w-80 rounded-full bg-brand-600/30 blur-3xl"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-widest text-brand-400">Start your project</p>
            <h1 class="mt-2 font-display text-5xl font-bold uppercase text-white sm:text-6xl">Request a quote</h1>
            <p class="mt-4 max-w-2xl text-lg text-white/80">
                Tell us about your project and upload any available drawings or models. You don't need to have every detail ready.
                Our team will review the information and get back to you with the next steps.
            </p>
        </div>
    </section>

    <section class="bg-surface py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6">

            @if ($errors->any())
                <div class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <p class="font-semibold">Please fix the following and send again (files need to be selected again):</p>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <ol class="mb-6 grid grid-cols-2 gap-2 sm:grid-cols-4" aria-label="Progress">
                @foreach ($stepNames as $index => $name)
                    <li data-step-label class="rounded-md border border-line bg-white px-3 py-2 text-center text-xs font-bold uppercase tracking-wider text-muted">
                        {{ $index + 1 }}. {{ $name }}
                    </li>
                @endforeach
            </ol>

            <form id="quote-form" method="POST" action="{{ route('quote.store') }}" enctype="multipart/form-data"
                  data-show-all="{{ $errors->any() ? 'true' : 'false' }}"
                  class="rounded-xl border border-line bg-white p-6 shadow-sm sm:p-8">
                @csrf

                {{-- Honeypot: hidden from people, filled in by bots. --}}
                <div class="absolute -left-[9999px]" aria-hidden="true">
                    <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                {{-- Step 1 --}}
                <div data-step class="space-y-5">
                    <h2 class="font-display text-3xl font-bold uppercase text-ink">Your details</h2>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="{{ $label }}">Full name *</label>
                            <input id="name" name="name" type="text" value="{{ old('name', auth()->user()?->name) }}" required autocomplete="name" class="{{ $input }}">
                        </div>
                        <div>
                            <label for="email" class="{{ $label }}">Email *</label>
                            <input id="email" name="email" type="email" value="{{ old('email', auth()->user()?->email) }}" required autocomplete="email" class="{{ $input }}">
                        </div>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="{{ $label }}">Phone</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}" autocomplete="tel" class="{{ $input }}">
                        </div>
                        <div>
                            <label for="company" class="{{ $label }}">Company</label>
                            <input id="company" name="company" type="text" value="{{ old('company') }}" autocomplete="organization" class="{{ $input }}">
                        </div>
                    </div>
                    <div>
                        <label for="client_type" class="{{ $label }}">I am a</label>
                        <select id="client_type" name="client_type" class="{{ $input }}">
                            <option value="">Select</option>
                            @foreach (config('enquiry.client_types') as $type)
                                <option value="{{ $type }}" @selected(old('client_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div data-nav class="flex justify-end pt-2">
                        <button type="button" data-next class="btn btn-primary">Next</button>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div data-step class="mt-10 space-y-5 border-t border-line pt-8">
                    <h2 class="font-display text-3xl font-bold uppercase text-ink">Project</h2>
                    <div>
                        <label for="project_name" class="{{ $label }}">Project name *</label>
                        <input id="project_name" name="project_name" type="text" value="{{ old('project_name') }}" required class="{{ $input }}">
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="project_type" class="{{ $label }}">Project type *</label>
                            <select id="project_type" name="project_type" required class="{{ $input }}">
                                <option value="">Select</option>
                                @foreach (config('enquiry.project_types') as $type)
                                    <option value="{{ $type }}" @selected(old('project_type') === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="location" class="{{ $label }}">Project location</label>
                            <input id="location" name="location" type="text" value="{{ old('location') }}" class="{{ $input }}">
                        </div>
                    </div>
                    <div data-nav class="flex justify-between pt-2">
                        <button type="button" data-prev class="btn btn-outline-dark">Back</button>
                        <button type="button" data-next class="btn btn-primary">Next</button>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div data-step class="mt-10 space-y-5 border-t border-line pt-8">
                    <h2 class="font-display text-3xl font-bold uppercase text-ink">Services</h2>
                    <fieldset data-services>
                        <legend class="{{ $label }}">Services required * (choose one or more)</legend>
                        <div class="mt-3 grid gap-2 sm:grid-cols-2">
                            @foreach (config('enquiry.services') as $service)
                                <label class="flex items-center gap-2 rounded-md border border-line px-3 py-2 text-sm text-ink hover:border-brand-500">
                                    <input type="checkbox" name="services[]" value="{{ $service }}" class="rounded border-line text-brand-600"
                                           @checked(in_array($service, old('services', [])))>
                                    {{ $service }}
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                    <p data-services-error class="hidden text-sm text-red-600">Please choose at least one service.</p>

                    <div>
                        <label for="message" class="{{ $label }}">Project requirements *</label>
                        <textarea id="message" name="message" rows="6" required
                                  placeholder="Project background, current stage, required outputs, coordination or documentation needs, special instructions"
                                  class="{{ $input }}">{{ old('message') }}</textarea>
                    </div>
                    <div data-nav class="flex justify-between pt-2">
                        <button type="button" data-prev class="btn btn-outline-dark">Back</button>
                        <button type="button" data-next class="btn btn-primary">Next</button>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div data-step class="mt-10 space-y-5 border-t border-line pt-8">
                    <h2 class="font-display text-3xl font-bold uppercase text-ink">Files and timing</h2>
                    <div>
                        <label for="files" class="{{ $label }}">Upload drawings or models</label>
                        <input id="files" name="files[]" type="file" multiple class="mt-2 block w-full text-sm">
                        <p class="mt-1 text-xs text-muted">Accepted: RVT, RFA, DWG, DXF, IFC, PDF, JPG, PNG, ZIP, DOC, DOCX, XLS, XLSX. Up to 10 files. Files are stored privately.</p>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="deadline" class="{{ $label }}">Deadline</label>
                            <select id="deadline" name="deadline" class="{{ $input }}">
                                <option value="">Select</option>
                                @foreach (config('enquiry.deadlines') as $option)
                                    <option value="{{ $option }}" @selected(old('deadline') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="budget" class="{{ $label }}">Estimated budget (optional)</label>
                            <select id="budget" name="budget" class="{{ $input }}">
                                <option value="">Select</option>
                                @foreach (config('enquiry.budgets') as $option)
                                    <option value="{{ $option }}" @selected(old('budget') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <label class="flex items-start gap-2 text-sm text-ink">
                        <input type="checkbox" name="confirm" value="1" required class="mt-1 rounded border-line text-brand-600">
                        <span>I confirm the information is accurate, I have permission to share the uploaded files, and I understand that submitting an enquiry does not mean BIM PORTAL has accepted the project.</span>
                    </label>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                        <button type="button" data-prev data-nav class="btn btn-outline-dark">Back</button>
                        <button type="submit" class="btn btn-primary">Submit project enquiry</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        (function () {
            var form = document.getElementById('quote-form');
            if (!form || form.dataset.showAll === 'true') { return; }

            var steps = Array.from(form.querySelectorAll('[data-step]'));
            var labels = Array.from(document.querySelectorAll('[data-step-label]'));
            var current = 0;

            function show(index, scroll) {
                current = index;
                steps.forEach(function (step, i) { step.classList.toggle('hidden', i !== index); });
                labels.forEach(function (label, i) {
                    label.classList.toggle('bg-brand-600', i <= index);
                    label.classList.toggle('text-white', i <= index);
                    label.classList.toggle('bg-white', i > index);
                    label.classList.toggle('text-muted', i > index);
                });
                if (scroll) { form.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
            }

            function valid(step) {
                var fields = step.querySelectorAll('input, select, textarea');
                for (var i = 0; i < fields.length; i++) {
                    if (!fields[i].checkValidity()) { fields[i].reportValidity(); return false; }
                }
                var services = step.querySelector('[data-services]');
                if (services && !services.querySelector('input:checked')) {
                    step.querySelector('[data-services-error]').classList.remove('hidden');
                    return false;
                }
                return true;
            }

            form.querySelectorAll('[data-next]').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (valid(steps[current])) { show(current + 1, true); }
                });
            });
            form.querySelectorAll('[data-prev]').forEach(function (button) {
                button.addEventListener('click', function () { show(current - 1, true); });
            });

            show(0, false);
        })();
    </script>
@endsection