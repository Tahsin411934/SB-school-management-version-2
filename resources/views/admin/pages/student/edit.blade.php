@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Nested Row within Card Body -->
        <div class="row">
            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
            <div class="col-lg-12">

                <div class="">
                    {{-- <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Edit Student</h1>
                    </div> --}}
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Student</h6>
                            @if (Session::has('msg'))
                                <div class="alert alert-success mt-4">
                                    <strong>{{ Session::get('msg') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="user" action="{{ URL::to('admin/update-student/' . $student->id) }}"
                                method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <h3>Edit Student Information</h3>
                                <br />
                                <div class="row align-items-center">
                                    <!-- First Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName"
                                                value="{{ old('firstName', $student->firstName) }}"
                                                placeholder="Enter your first name">
                                            @if ($errors->has('firstName'))
                                                <span class="text-danger">{{ $errors->first('firstName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Middle Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="middleName">Middle Name</label>
                                            <input type="text" class="form-control" id="middleName" name="middleName"
                                                value="{{ old('middleName', $student->middleName) }}"
                                                placeholder="Enter your middle name">
                                            @if ($errors->has('middleName'))
                                                <span class="text-danger">{{ $errors->first('middleName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName"
                                                value="{{ old('lastName', $student->lastName) }}"
                                                placeholder="Enter your last name">
                                            @if ($errors->has('lastName'))
                                                <span class="text-danger">{{ $errors->first('lastName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob"
                                                value="{{ old('dob', $student->dob) }}"
                                                placeholder="Enter your date of birth">
                                            @if ($errors->has('dob'))
                                                <span class="text-danger">{{ $errors->first('dob') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <label for="gender">Gender</label><br>
                                            <div class="d-flex justify-content-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="male"
                                                        name="gender" value="male"
                                                        {{ old('gender', $student->gender) == 'male' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="female"
                                                        name="gender" value="female"
                                                        {{ old('gender', $student->gender) == 'female' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="other"
                                                        name="gender" value="other"
                                                        {{ old('gender', $student->gender) == 'other' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="other">Other</label>
                                                </div>
                                            </div>
                                            @if ($errors->has('gender'))
                                                <span class="text-danger">{{ $errors->first('gender') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Nationality -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nationality">Nationality</label>
                                            <input type="text" class="form-control" id="nationality" name="nationality"
                                                value="{{ old('nationality', $student->nationality) }}"
                                                placeholder="Enter your nationality">
                                            @if ($errors->has('nationality'))
                                                <span class="text-danger">{{ $errors->first('nationality') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Birth Certificate NO -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="birthCertificateNO">Birth Certificate NO</label>
                                            <input type="text" class="form-control" id="birthCertificateNO"
                                                name="birthCertificateNO"
                                                value="{{ old('birthCertificateNO', $student->birthCertificateNO) }}"
                                                placeholder="Enter your Birth Certificate NO">
                                            @if ($errors->has('birthCertificateNO'))
                                                <span
                                                    class="text-danger">{{ $errors->first('birthCertificateNO') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Class -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="class">Class</label>
                                            <select class="form-control" id="class_id" name="class_id">
                                                <option value="" selected>Select your class</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('class_id'))
                                                <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Other Fields (Previous Institution, Area, City, etc.) -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="previousInstitution">Previous Institution</label>
                                            <input type="text" class="form-control" id="previousInstitution"
                                                name="previousInstitution"
                                                value="{{ old('previousInstitution', $student->previousInstitution) }}"
                                                placeholder="Enter your previous institution">
                                            @if ($errors->has('previousInstitution'))
                                                <span
                                                    class="text-danger">{{ $errors->first('previousInstitution') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- City Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                value="{{ old('city', $student->city) }}" placeholder="Enter your city">
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
                                                value="{{ old('phone', $student->phone) }}"
                                                placeholder="Enter your phone number">
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Present Address Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="presentAddress">Present Address</label>
                                            <textarea class="form-control" id="presentAddress" name="presentAddress" rows="3"
                                                placeholder="Enter your Present Address">{{ old('presentAddress', $student->presentAddress) }}</textarea>
                                            @if ($errors->has('presentAddress'))
                                                <span class="text-danger">{{ $errors->first('presentAddress') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Emergency Contact No Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emergency_phone">Emergency Contact No</label>
                                            <input type="text" class="form-control" id="emergency_phone"
                                                name="emergency_phone"
                                                value="{{ old('emergency_phone', $student->emergency_phone) }}"
                                                placeholder="Enter your Emergency Contact No">
                                            @if ($errors->has('emergency_phone'))
                                                <span class="text-danger">{{ $errors->first('emergency_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Blood Group Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="studentBloodGroup">Blood Group</label>
                                            <input type="text" class="form-control" id="studentBloodGroup"
                                                name="studentBloodGroup"
                                                value="{{ old('studentBloodGroup', $student->studentBloodGroup) }}"
                                                placeholder="Enter your Student Blood Group">
                                            @if ($errors->has('studentBloodGroup'))
                                                <span class="text-danger">{{ $errors->first('studentBloodGroup') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Hobby Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="hobby">Hobby</label>
                                            <input type="text" class="form-control" id="hobby" name="hobby"
                                                value="{{ old('hobby', $student->hobby) }}"
                                                placeholder="Enter your Hobby">
                                            @if ($errors->has('hobby'))
                                                <span class="text-danger">{{ $errors->first('hobby') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Special Skills Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="specialSkills">Special Skills</label>
                                            <input type="text" class="form-control" id="specialSkills"
                                                name="specialSkills"
                                                value="{{ old('specialSkills', $student->specialSkills) }}"
                                                placeholder="Enter your Special Skills">
                                            @if ($errors->has('specialSkills'))
                                                <span class="text-danger">{{ $errors->first('specialSkills') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Is Sibling Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="is_sibling">Is Sibling?</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="is_sibling_yes"
                                                    name="is_sibling" value="1"
                                                    {{ old('is_sibling', $student->is_sibling) == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_sibling_yes">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="is_sibling_no"
                                                    name="is_sibling" value="0"
                                                    {{ old('is_sibling', $student->is_sibling) == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_sibling_no">
                                                    No
                                                </label>
                                            </div>
                                            @if ($errors->has('is_sibling'))
                                                <span class="text-danger">{{ $errors->first('is_sibling') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="image">Profile Image</label>
                                            @if ($student->image)
                                                <!-- Display the current image -->
                                                <div class="mb-2">
                                                    <img src="{{ asset('public/storage/' . $student->image) }}"
                                                        alt="Profile Image" class="img-fluid" style="max-height: 150px;">
                                                </div>
                                            @else
                                                <!-- Placeholder if no image exists -->
                                                <div class="mb-2">
                                                    <img src="{{ asset('public/path/to/placeholder/image.jpg') }}"
                                                        alt="Profile Image" class="img-fluid" style="max-height: 150px;">
                                                </div>
                                            @endif
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
                                <h3>Father's Information</h3> <br />
                                <div class="row">
                                    <!-- Father's Name Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathersName">Father's Name</label>
                                            <input type="text" class="form-control" id="fathersName"
                                                name="fathersName"
                                                value="{{ old('fathersName', $student->fathersName ?? '') }}"
                                                placeholder="Enter your Father's Name">
                                            @if ($errors->has('fathersName'))
                                                <span class="text-danger">{{ $errors->first('fathersName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Father's Occupation Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathers_occupation">Father's Occupation</label>
                                            <input type="text" class="form-control" id="fathers_occupation"
                                                name="fathers_occupation"
                                                value="{{ old('fathers_occupation', $student->fathers_occupation ?? '') }}"
                                                placeholder="Enter your Father's Occupation">
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
                                                name="fathersCompanyName"
                                                value="{{ old('fathersCompanyName', $student->fathersCompanyName ?? '') }}"
                                                placeholder="Enter your Father's Company Name">
                                            @if ($errors->has('fathersCompanyName'))
                                                <span
                                                    class="text-danger">{{ $errors->first('fathersCompanyName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Father's Office Address Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathersOfficeAddress">Office Address</label>
                                            <textarea class="form-control" id="fathersOfficeAddress" name="fathersOfficeAddress" rows="3"
                                                placeholder="Enter your Father's Office Address">{{ old('fathersOfficeAddress', $student->fathersOfficeAddress ?? '') }}</textarea>
                                            @if ($errors->has('fathersOfficeAddress'))
                                                <span
                                                    class="text-danger">{{ $errors->first('fathersOfficeAddress') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Father's Phone Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fathers_phone">Phone</label>
                                            <input type="text" class="form-control" id="fathers_phone"
                                                name="fathers_phone"
                                                value="{{ old('fathers_phone', $student->fathers_phone ?? '') }}"
                                                placeholder="Enter your Father's Phone Number">
                                            @if ($errors->has('fathers_phone'))
                                                <span class="text-danger">{{ $errors->first('fathers_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h3>Mother's Information</h3> <br />
                                <div class="row">
                                    <!-- Mother's Name Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothersName">Mother's Name</label>
                                            <input type="text" class="form-control" id="mothersName"
                                                name="mothersName"
                                                value="{{ old('mothersName', $student->mothersName ?? '') }}"
                                                placeholder="Enter your Mother's Name">
                                            @if ($errors->has('mothersName'))
                                                <span class="text-danger">{{ $errors->first('mothersName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Mother's Occupation Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothers_occupation">Mother's Occupation</label>
                                            <input type="text" class="form-control" id="mothers_occupation"
                                                name="mothers_occupation"
                                                value="{{ old('mothers_occupation', $student->mothers_occupation ?? '') }}"
                                                placeholder="Enter your Mother's Occupation">
                                            @if ($errors->has('mothers_occupation'))
                                                <span
                                                    class="text-danger">{{ $errors->first('mothers_occupation') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Mother's Company Name Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothersCompanyName">Company Name</label>
                                            <input type="text" class="form-control" id="mothersCompanyName"
                                                name="mothersCompanyName"
                                                value="{{ old('mothersCompanyName', $student->mothersCompanyName ?? '') }}"
                                                placeholder="Enter your Mother's Company Name">
                                            @if ($errors->has('mothersCompanyName'))
                                                <span
                                                    class="text-danger">{{ $errors->first('mothersCompanyName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Mother's Office Address Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothersOfficeAddress">Office Address</label>
                                            <textarea class="form-control" id="mothersOfficeAddress" name="mothersOfficeAddress" rows="3"
                                                placeholder="Enter your Mother's Office Address">{{ old('mothersOfficeAddress', $student->mothersOfficeAddress ?? '') }}</textarea>
                                            @if ($errors->has('mothersOfficeAddress'))
                                                <span
                                                    class="text-danger">{{ $errors->first('mothersOfficeAddress') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Mother's Phone Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mothers_phone">Phone</label>
                                            <input type="text" class="form-control" id="mothers_phone"
                                                name="mothers_phone"
                                                value="{{ old('mothers_phone', $student->mothers_phone ?? '') }}"
                                                placeholder="Enter your Mother's Phone Number">
                                            @if ($errors->has('mothers_phone'))
                                                <span class="text-danger">{{ $errors->first('mothers_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <h3>Local Guardian Information</h3> <br />
                                <div class="row">
                                    <!-- Local Guardian Name Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localGuardianName">Local Guardian Name</label>
                                            <input type="text" class="form-control" id="localGuardianName"
                                                name="localGuardianName"
                                                value="{{ old('localGuardianName', $student->localGuardianName ?? '') }}"
                                                placeholder="Enter your Local Guardian Name">
                                            @if ($errors->has('localGuardianName'))
                                                <span class="text-danger">{{ $errors->first('localGuardianName') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Local Guardian Occupation Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localGuardian_occupation">Occupation</label>
                                            <input type="text" class="form-control" id="localGuardian_occupation"
                                                name="localGuardian_occupation"
                                                value="{{ old('localGuardian_occupation', $student->localGuardian_occupation ?? '') }}"
                                                placeholder="Enter your Local Guardian Occupation">
                                            @if ($errors->has('localGuardian_occupation'))
                                                <span
                                                    class="text-danger">{{ $errors->first('localGuardian_occupation') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Local Guardian Phone Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="localGuardian_phone">Phone</label>
                                            <input type="text" class="form-control" id="localGuardian_phone"
                                                name="localGuardian_phone"
                                                value="{{ old('localGuardian_phone', $student->localGuardian_phone ?? '') }}"
                                                placeholder="Enter your Local Guardian Phone Number">
                                            @if ($errors->has('localGuardian_phone'))
                                                <span
                                                    class="text-danger">{{ $errors->first('localGuardian_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <input name="submit" type="submit" value="Update"
                                    class="btn btn-primary btn-user btn-block">


                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
