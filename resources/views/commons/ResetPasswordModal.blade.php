<div class="popup">
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="form-section"> Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body reset-form">
                    <div class="content-header row">

                        <div class="content-header-right col-md-6 col-12">
                            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                            </div>
                        </div>
                    </div>
                    <div class="content-body">
                        <section id="basic-form-layouts">
                            <div class="row match-height">
                                <div class="col-md-12">
                                    <div class="card reset-password-card no-close">
                                        <div class="card-content collapse show">
                                            <div class="card-body ">

                                                <form id="confirmation-form" method="POST" action="{{ route('reset-password-form') }}">
                                                    @csrf
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="pass1">New Password</label>
                                                                    <input type="password" id="pass1" class="form-control no-close"
                                                                           placeholder="Input new password"
                                                                           name="internalUserManagmentPassword"
                                                                           required
                                                                           value="{{old('internalUserManagmentPassword')}}"
                                                                    >
                                                                    <input type='hidden' name='user_id' value="@isset($userId) {{$userId}} @endisset">
                                                                    @error('internalUserManagmentPassword')
                                                                    <div class="alert alert-danger mb-2">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="pass2">Confirmation Password</label>
                                                                    <input type="password" id="pass2" class="form-control no-close" placeholder="Password Confirmation"
                                                                           name="internalUserManagmentPasswordConfirmation"
                                                                           required
                                                                           value="{{old('internalUserManagmentPasswordConfirmation')}}"
                                                                    >
                                                                    @error('internalUserManagmentPasswordConfirmation')
                                                                    <div class="alert alert-danger mb-2">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="form-actions">

                                                            <a href="{{ route('user.index') }}">
                                                                <button type="button" class="btn btn-warning mr-1 button-cancel">
                                                                    <i class="ft-x"></i>&nbsp;Cancel
                                                                </button>
                                                            </a>
                                                            <button type="submit" class="btn btn-primary" id="submit-confirmation-form">
                                                                <i class="la la-check-square-o"></i>&nbsp;Save
                                                            </button>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- // Basic form layout section end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>













