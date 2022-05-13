
                <form id="update_form" method='post' class="j-pro" enctype="multipart/form-data" data-parsley-validate="" style="box-shadow:none; background: none" data-action='{{ route('mailing_list_group.update', $group->id) }}'>
                    @csrf
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
                        <label for="emails"></label>
                        <select name="emails[]" multiple class="selectpicker form-control" id="emails">
                            <option disabled>{{ _i('Select') }}</option>
                                @foreach($emails as $email)
                                    <option value="{{ $email->id }}" {{ in_array($email->id, $group_emails) ? 'selected' : '' }}>{{ $email->email }}</option>
                                @endforeach
                        </select>
                    </div>
                </form>
