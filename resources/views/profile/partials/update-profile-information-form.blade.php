<section>
    <a href="{{ route('index.levelup') }}"
        class="inline-flex items-center justify-center w-16 h-16 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800">
        <span>{{ __('Back to Levelup ') }}</span>
    </a>
    <header>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>


    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Information du profil -->
        <div>
            <x-input-label for="name" :value="('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>



        <!-- Sélection de la formation -->
        <div class="mb-6">
            <x-input-label for="course" :value="('Choose your course')" />
            <select name="course_id" id="course"
                class="form-control mt-2 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                <option value="">Choisissez un cours</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @if($course->id == old('course_id', $user->course_id)) selected @endif>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Liste déroulante des matières -->
        <div class="mb-6">
            <x-input-label for="subject" :value="('Choose your subject')" />
            <select name="subject_id" id="subject"
                class="form-control mt-2 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                <option value="">Choisissez une matière</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @if($subject->id == old('subject_id', $user->subject_id)) selected
                    @endif>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Bouton de sauvegarde -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    function updateSubjects() {
        const courseId = document.getElementById('course').value;
        const subjectSelect = document.getElementById('subject');

        // Réinitialiser les matières
        subjectSelect.innerHTML = '<option value="">Choisissez une matière</option>';

        // Si un cours est sélectionné, vous pouvez éventuellement faire une requête AJAX pour récupérer les matières
        if (courseId) {
            $.ajax({
                url: '/api/subjects/' + courseId, // Assurez-vous que cette route existe
                method: 'GET',
                success: function (data) {
                    data.forEach(function (subject) {
                        const option = new Option(subject.name, subject.id);
                        subjectSelect.add(option);
                    });
                },
                error: function () {
                    console.error('Erreur lors de la récupération des matières.');
                }
            });
        }
    }
</script>