<section>
    <div class="card-header">
        <h3>{{ __('Delete Account') }}</h3>
    </div>

    <div class="card-body">
        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>


        <div x-data="{ open: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">

            <x-danger-button class="btn btn-danger" x-on:click="open = ! open">
                {{ __('Delete Account') }}
            </x-danger-button>

            <div x-show="open" @click.outside="open = false">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                     <p style="margin-top:1em">
                        {{ __('Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="form-group" style="margin-bottom:10px">
 
                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control"
                            placeholder="{{ __('Password') }}"
                        />

                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <x-secondary-button x-on:click="open = false">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button x-on:click="open = true" class="btn btn-danger">
                            {{ __('Delete Account') }}
                        </x-danger-button>
                    </div>
                </form>
            </div>            
        </div>
    </div>
</section>