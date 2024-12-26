@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Nested Row within Card Body -->
        <div class="row">
            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
            <div class="col-lg-12">
                <div class="">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Student</h6>
                            @if (Session::has('msg'))
                                <div class="alert alert-success mt-4">
                                    <strong>{{ Session::get('msg') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="user" action="{{ URL::to('admin/store-student') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <h3>Student Information</h3>
                                <br />
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName"
                                                value="{{ old('firstName') }}" placeholder="Enter your firstName">
                                            @if ($errors->has('firstName'))
                                                <span class="text-danger">{{ $errors->first('firstName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="middleName">Middle Name</label>
                                            <input type="text" class="form-control" id="middleName" name="middleName"
                                                value="{{ old('middleName') }}" placeholder="Enter your middleName">
                                            @if ($errors->has('middleName'))
                                                <span class="text-danger">{{ $errors->first('middleName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName"
                                                value="{{ old('lastName') }}" placeholder="Enter your lastName">
                                            @if ($errors->has('lastName'))
                                                <span class="text-danger">{{ $errors->first('lastName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob"
                                                value="{{ old('dob') }}" placeholder="Enter your dob">
                                            @if ($errors->has('dob'))
                                                <span class="text-danger">{{ $errors->first('dob') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="gender">Gender</label><br>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="male"
                                                        name="gender" value="male"
                                                        {{ old('gender') == 'male' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="female"
                                                        name="gender" value="female"
                                                        {{ old('gender') == 'female' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="other"
                                                        name="gender" value="other"
                                                        {{ old('gender') == 'other' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="other">Other</label>
                                                </div>
                                            </div>
                                            @if ($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nationality">Nationality</label>
                                            <input type="text" class="form-control" id="nationality" name="nationality"
                                                value="{{ old('nationality') }}" placeholder="Enter your nationality">
                                            @if ($errors->has('nationality'))
                                                <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="birthCertificateNO">Birth Certificate NO</label>
                                            <input type="text" class="form-control" id="birthCertificateNO"
                                                name="birthCertificateNO" value="{{ old('birthCertificateNO') }}"
                                                placeholder="Enter your Birth Certificate NO">
                                            @if ($errors->has('birthCertificateNO'))
                                                <span
                                                    class="text-danger">{{ $errors->first('birthCertificateNO') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Class Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="class">Class</label>
                                            <select class="form-control" id="class_id" name="class_id">
                                                <option value="" selected>Select your class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('class_id'))
                                                <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Previous Institution Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="previousInstitution">Previous Institution</label>
                                            <input type="text" class="form-control" id="previousInstitution"
                                                name="previousInstitution" value="{{ old('previousInstitution') }}"
                                                placeholder="Enter your previous institution">
                                            @if ($errors->has('previousInstitution'))
                                                <span
                                                    class="text-danger">{{ $errors->first('previousInstitution') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="area">Area</label>
                                            <input type="text" class="form-control" id="area" name="area"
                                                value="{{ old('area') }}" placeholder="Enter your area">
                                            @if ($errors->has('area'))
                                                <span class="text-danger">{{ $errors->first('area') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- City Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ old('city') }}" placeholder="Enter your city">
                                            @if ($errors->has('city'))
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Phone Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                value="{{ old('phone') }}" placeholder="Enter your phone number">
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="presentAddress">Present Address</label>
                                            <textarea class="form-control" id="presentAddress" name="presentAddress" rows="3"
                                                placeholder="Enter your Present Address">{{ old('presentAddress') }}</textarea>
                                            @if ($errors->has('presentAddress'))
                                                <span class="text-danger">{{ $errors->first('presentAddress') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emergency_phone">Emergency Contact No</label>
                                            <input type="text" class="form-control" id="emergency_phone"
                                                name="emergency_phone" value="{{ old('emergency_phone') }}"
                                                placeholder="Enter your Emergency Contact No">
                                            @if ($errors->has('emergency_phone'))
                                                <span class="text-danger">{{ $errors->first('emergency_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="studentBloodGroup">Blood Group</label>
                                            <input type="text" class="form-control" id="studentBloodGroup"
                                                name="studentBloodGroup" value="{{ old('studentBloodGroup') }}"
                                                placeholder="Enter your Student Blood Group">
                                            @if ($errors->has('studentBloodGroup'))
                                                <span class="text-danger">{{ $errors->first('studentBloodGroup') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="hobby">Hobby</label>
                                            <input type="text" class="form-control" id="hobby" name="hobby"
                                                value="{{ old('hobby') }}" placeholder="Enter your Hobby">
                                            @if ($errors->has('hobby'))
                                                <span class="text-danger">{{ $errors->first('hobby') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="specialSkills">Special Skills</label>
                                            <input type="text" class="form-control" id="specialSkills"
                                                name="specialSkills" value="{{ old('specialSkills') }}"
                                                placeholder="Enter your Special Skills">
                                            @if ($errors->has('specialSkills'))
                                                <span class="text-danger">{{ $errors->first('specialSkills') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="is_sibling">Is Sibling?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="is_sibling_yes"
                                                    name="is_sibling" value="1"
                                                    {{ old('is_sibling') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_sibling_yes">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="is_sibling_no"
                                                    name="is_sibling" value="0"
                                                    {{ old('is_sibling') == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_sibling_no">
                                                    No
                                                </label>
                                            </div>
                                            @if ($errors->has('is_sibling'))
                                                <span class="text-danger">{{ $errors->first('is_sibling') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image">Profile Image</label>

                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*">
                                            <small class="form-text text-muted">Accepted file types: jpeg, png, jpg, gif.
                                                Max size: 5MB.</small>
                                            @if ($errors->has('image'))
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <h3>Fathers Information</h3> <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathersName">Father's Name</label>
                                            <input type="text" class="form-control" id="fathersName"
                                                name="fathersName" value="{{ old('fathersName') }}"
                                                placeholder="Enter your Father Name">
                                            @if ($errors->has('fathersName'))
                                                <span class="text-danger">{{ $errors->first('fathersName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathers_occupation">Father's Occupation</label>
                                            <input type="text" class="form-control" id="fathers_occupation"
                                                name="fathers_occupation" value="{{ old('fathers_occupation') }}"
                                                placeholder="Enter your fathers_occupation">
                                            @if ($errors->has('fathers_occupation'))
                                                <span
                                                    class="text-danger">{{ $errors->first('fathers_occupation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Father's Company Name Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathersCompanyName">Father's Company Name</label>
                                            <input type="text" class="form-control" id="fathersCompanyName"
                                                name="fathersCompanyName" value="{{ old('fathersCompanyName') }}"
                                                placeholder="Enter your father's company name">
                                            @if ($errors->has('fathersCompanyName'))
                                                <span
                                                    class="text-danger">{{ $errors->first('fathersCompanyName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathersOfficeAddress">Office Address</label>
                                            <textarea class="form-control" id="fathersOfficeAddress" name="fathersOfficeAddress" rows="3"
                                                placeholder="Enter your Office Address">{{ old('fathersOfficeAddress') }}</textarea>
                                            @if ($errors->has('fathersOfficeAddress'))
                                                <span
                                                    class="text-danger">{{ $errors->first('fathersOfficeAddress') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathers_phone">Phone</label>
                                            <input type="text" class="form-control" id="fathers_phone"
                                                name="fathers_phone" value="{{ old('fathers_phone') }}"
                                                placeholder="Enter your Phone number">
                                            @if ($errors->has('fathers_phone'))
                                                <span class="text-danger">{{ $errors->first('fathers_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h3>Mothers Information</h3> <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothersName">Mother's Name</label>
                                            <input type="text" class="form-control" id="mothersName"
                                                name="mothersName" value="{{ old('mothersName') }}"
                                                placeholder="Enter your Mother Name">
                                            @if ($errors->has('mothersName'))
                                                <span class="text-danger">{{ $errors->first('mothersName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothers_occupation">Mother's Occupation</label>
                                            <input type="text" class="form-control" id="mothers_occupation"
                                                name="mothers_occupation" value="{{ old('mothers_occupation') }}"
                                                placeholder="Enter your Mother Occupation">
                                            @if ($errors->has('mothers_occupation'))
                                                <span
                                                    class="text-danger">{{ $errors->first('mothers_occupation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothersCompanyName">Company Name</label>
                                            <input type="text" class="form-control" id="mothersCompanyName"
                                                name="mothersCompanyName" value="{{ old('mothersCompanyName') }}"
                                                placeholder="Enter your company name">
                                            @if ($errors->has('mothersCompanyName'))
                                                <span
                                                    class="text-danger">{{ $errors->first('mothersCompanyName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothersOfficeAddress">Office Address</label>
                                            <textarea class="form-control" id="mothersOfficeAddress" name="mothersOfficeAddress" rows="3"
                                                placeholder="Enter your Office Address">{{ old('mothersOfficeAddress') }}</textarea>
                                            @if ($errors->has('mothersOfficeAddress'))
                                                <span
                                                    class="text-danger">{{ $errors->first('mothersOfficeAddress') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothers_phone">Phone</label>
                                            <input type="text" class="form-control" id="mothers_phone"
                                                name="mothers_phone" value="{{ old('mothers_phone') }}"
                                                placeholder="Enter your Phone number">
                                            @if ($errors->has('mothers_phone'))
                                                <span class="text-danger">{{ $errors->first('mothers_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h3>Local Gurdian Information</h3> <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localGuardianName">Local Guardian Name</label>
                                            <input type="text" class="form-control" id="localGuardianName"
                                                name="localGuardianName" value="{{ old('localGuardianName') }}"
                                                placeholder="Enter your Loacal Gurdian Name">
                                            @if ($errors->has('localGuardianName'))
                                                <span class="text-danger">{{ $errors->first('localGuardianName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localGuardian_occupation">Occupation</label>
                                            <input type="text" class="form-control" id="localGuardian_occupation"
                                                name="localGuardian_occupation"
                                                value="{{ old('localGuardian_occupation') }}"
                                                placeholder="Enter your Local Gurdian Occupation">
                                            @if ($errors->has('localGuardian_occupation'))
                                                <span
                                                    class="text-danger">{{ $errors->first('localGurdian_occupation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localGuardian_phone">Phone</label>
                                            <input type="text" class="form-control" id="localGuardian_phone"
                                                name="localGuardian_phone" value="{{ old('localGuardian_phone') }}"
                                                placeholder="Enter your Phone number">
                                            @if ($errors->has('localGuardian_phone'))
                                                <span
                                                    class="text-danger">{{ $errors->first('localGuardian_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <input name="submit" type="submit" value="Create"
                                    class="btn btn-primary btn-user btn-block">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
