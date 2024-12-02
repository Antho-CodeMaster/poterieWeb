<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Mettre à jour la question de sécurité') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Cette question vous sera posée si vous voulez récupérer votre mot de passe.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.question.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Question de sécurité')" />
            <select name="question" id="question" class="rounded-md">
                @if(Auth::user()->id_question_securite == null)
                    <option disabled selected>
                        AUCUNE QUESTION DÉFINIE.
                    </option>
                @endif
                @foreach($security_questions as $q)
                <option value="{{$q->id_question}}" {{ Auth::user()->id_question_securite == $q->id_question ? 'selected' : '' }}>
                    {{$q->question }}

                </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->updateQuestion->get('question')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_question_reponse" :value="__('Réponse')" />
            <x-text-input id="update_question_reponse" name="reponse" type="password" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->updateQuestion->get('reponse')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_question_reponse_confirmation" :value="__('Confirmer la réponse')" />
            <x-text-input id="update_question_reponse_confirmation" name="reponse_confirmation" type="password" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->updateQuestion->get('reponse_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-button.green.empty class="hover:bg-lightVert bg-vert">{{ __('Sauvegarder') }}</x-button.green.empty>
        </div>
    </form>
</section>
