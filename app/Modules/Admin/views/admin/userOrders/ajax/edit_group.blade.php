
                <form id="update_form" method='post' class="j-pro" enctype="multipart/form-data" data-parsley-validate="" style="box-shadow:none; background: none" data-action='{{ route('groups.update', $group->id) }}'>
                    @csrf
                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="title">
                                <i class="icofont icofont-ui-check"></i>
                            </label>
                            <input type="text" id="title" name="title" placeholder="Title" required value='{{ $group->title }}'>
                        </div>
                        <span class="text-danger">
                            <strong id="title-error"></strong>
                        </span>
                    </div>

                    <div class="j-unit">
                        <div class="j-input j-append-big-btn">
                            <label class="j-icon-left" for="file_input">
                                <i class="icofont icofont-download"></i>
                            </label>
                            <div class="j-file-button">
                                {{ _i('Browse') }}
                                <input type="file" name="icon"
                                       onchange="document.getElementById('file_input').value = this.value;">
                            </div>
                            <input type="text" id="file_input" readonly="" placeholder="no file selected">
                            <span class="j-hint">{{ _i('Only: jpg / png / doc, less 1Mb') }}</span>
                        </div>
                    </div>

                    <div>
                        <label for="users"></label>
                        <select name="users[]" multiple class="selectpicker form-control" id="users" required>
                            <option disabled>{{ _i('Select') }}</option>
                            @if(count($users) > 0)
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $group_users) ? 'selected' : '' }}>{{ $user->name }} {{ $user->lastname }}</option>
                                @endforeach
                            @else
                                {{ _i('NO Users') }}
                            @endif
                        </select>
                    </div>
                </form>
