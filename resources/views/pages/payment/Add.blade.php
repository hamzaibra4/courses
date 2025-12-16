@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">Payments</h3>

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            @can('List_Payments')
                                <li class="breadcrumb-item">
                                    <a href="{{ route('payment.index') }}">Home</a>
                                </li>
                            @endcan
                            <li class="breadcrumb-item active">
                                {{ $payments ? 'Edit Payment' : 'Add Payment' }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section id="file-export">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Payments</h4>
                                <a class="heading-elements-toggle">
                                    <i class="la la-ellipsis-v font-medium-3"></i>
                                </a>

                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body">

                                    <form action="{{ $payments ? route('payment.update', $payments->id) : route('payment.store') }}"
                                          method="POST" class="floating-labels" enctype="multipart/form-data">

                                        @csrf
                                        @if($payments)
                                            @method('PUT')
                                        @endif
                                        <div class="form-body">
                                            <div class="row">

                                                @if($payments)

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="student_id">Student<span>*</span></label>
                                                            <input id="student_id" readonly type="text" class="form-control"
                                                                   name="student_id" placeholder=""
                                                                   value="{{ $payments->getStudent->f_name }} {{ $payments->getStudent->l_name }}">

                                                            @error('student_id')
                                                            <div class="error-msg">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                @else

                                                <div class="form-group cust-form-input col-12">
                                                    <label for="student_id">Student<span class="is-required">*</span></label>
                                                    @php $current = old('student_id', optional($payments)->student_id); @endphp
                                                    <select class="form-control my-2 select2" name="student_id" id="student_id" required>
                                                        <option value="" {{ $current ? '' : 'selected' }}>Select Student</option>
                                                        @foreach($students as $id => $name)
                                                            <option value="{{ $id }}" @selected($current == $id)>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('student_id') <div class="error-msg">{{ $message }}</div> @enderror
                                                </div>
                                                @endif

                                                @if($payments)
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="enrollment_number">Enrollment Number<span>*</span></label>
                                                            <input id="enrollment_number" readonly type="text" class="form-control"
                                                                   name="enrollment_number" placeholder=""
                                                                   value="{{ $payments->getEnrollment->enrollment_number }}">

                                                            @error('enrollment_number')
                                                            <div class="error-msg">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                @else

                                                <div class="form-group cust-form-input col-12">
                                                    <label for="enrollment_number">Enrollment Number<span class="is-required">*</span></label>
                                                    <select class="form-control my-2 select2" name="enrollment_number" id="enrollment_number" required>
                                                        <option value="">Select Enrollment Number</option>
                                                    </select>
                                                    @error('enrollment_number') <div class="error-msg">{{ $message }}</div> @enderror
                                                    <p id="remaingincontainer" class="small-text onadd">The remaining amount is: <span id="theremaining"></span>$</p>
                                                </div>
                                                @endif

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="date">Date<span>*</span></label>
                                                        <input id="date" type="text" class="form-control dobpickdate_year" name="date" required  value="{{ old('date', $payments->date ?? now()->format('Y-m-d')) }}">
                                                        @error('date')
                                                        <div class='error-msg'>{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="amount">Amount<span>*</span></label>
                                                        <input id="amount" required type="number" class="form-control"
                                                               name="amount" placeholder="Enter Amount"
                                                               value="{{ old('amount', $payments->amount ?? '') }}">

                                                        @error('amount')
                                                        <div class="error-msg">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-actions">

                                                    @can('List_Payments')
                                                        <a href="{{ route('payment.index') }}" class="btn btn-warning mr-1 button-cancel">
                                                            <i class="ft-x"></i>&nbsp;Cancel
                                                        </a>
                                                    @endcan
                                                        @canany(['Add_Payments', 'Edit_Payments'])
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="la la-check-square-o"></i> Save
                                                            </button>
                                                        @endcanany

                                                </div>
                                            </div>
                                        </div>


                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section>
        </div>

    </div>
@endsection

@section('customjs')
    <script src="{{ asset('cms/custom/payment.js') }}" type="text/javascript"></script>
@endsection
