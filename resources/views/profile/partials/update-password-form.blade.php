<section>
        <div class="card-header">
            <h3>{{ __('Update Password') }}</h3>
        </div>

        <div class="card-body">
            <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div class="form-group" style="margin-bottom:10px">
                    <x-input-label for="current_password" :value="__('Current Password')" />
                    <x-text-input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div class="form-group" style="margin-bottom:10px">
                    <x-input-label for="password" :value="__('New Password')" />
                    <x-text-input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div class="form-group" style="margin-bottom:10px">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2"/>
                </div>

                <div class="form-group">
                      <div style="display:inline-block;">
                        <x-primary-button class="btn btn-success" style="display:inline-block;">{{ __('Save') }}</x-primary-button>
                      </div>
                      @if (session('status') === 'password-updated')
                        <div style="display:inline-block;">
                          <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-muted"                          
                          >{{ __('Saved.') }}</p>
                        </div>
                      @endif
                </div>
            </form>
        </div>
</section>
