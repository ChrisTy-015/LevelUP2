<section>
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('user.profile.show') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            {{ __('Retour au profil') }}
        </a>
        <a href="{{ route('index.levelup') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-blue-800 uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-300 focus:bg-blue-700 dark:focus:bg-blue-300 active:bg-blue-900 dark:active:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            {{ __('Retour à LevelUp') }}
        </a>
    </div>

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
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
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

        <!-- Sélection du statut -->
        <div class="mb-6">
            <x-input-label for="status" :value="__('Votre statut')" />
            <select name="status" id="status"
                class="form-control mt-2 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                <option value="">Choisissez votre statut</option>
                <option value="Mentee" @if(old('status', $user->status) === 'Mentee') selected @endif>Mentee</option>
                <option value="Mentor" @if(old('status', $user->status) === 'Mentor') selected @endif>Mentor</option>
                <option value="Les deux" @if(old('status', $user->status) === 'Les deux') selected @endif>Les deux</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <!-- Sélection de la formation -->
        <div class="mb-6">
            <x-input-label for="course" :value="__('Votre formation')" />
            <select name="course_id" id="course"
                class="form-control mt-2 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                <option value="">Choisissez une formation</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @if($course->id == old('course_id', $user->course_id)) selected @endif>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('course_id')" />
        </div>

        <!-- Liste déroulante des matières -->
        <div class="mb-6">
            <x-input-label for="subjects" :value="__('Vos matières enseignées')" />
            <select name="subjects[]" id="subjects" multiple
                class="form-control mt-2 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" 
                        @if(in_array($subject->id, old('subjects', $user->subjects->pluck('id')->toArray()))) selected @endif>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('subjects')" />
            <p class="mt-1 text-sm text-gray-500">Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs matières</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Enregistré.') }}</p>
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