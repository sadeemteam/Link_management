<div class="card p-4">
    <h5>{{__('SMTP Setup')}}</h5>
    <small>{{__('For email send to user')}}</small>

    <form 
        method="POST" 
        action="{{route('settings.smtp')}}"
    >
        @csrf
        @method('PUT')

        <div class="row mt-4">
            <div class="col-12 col-md-6 mb-4">
                <label class="form-label">{{__('SMTP Host')}}</label>
                <input 
                    required 
                    type="text" 
                    name="smtp_host"
                    value="{{$smtp->host}}"
                    placeholder="Your smtp host"
                    class="form-control px-2" 
                >
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label class="form-label">{{__('SMTP Port')}}</label>
                <input 
                    required 
                    type="text" 
                    name="smtp_port"
                    value="{{$smtp->port}}"
                    placeholder="Your smtp port"
                    class="form-control px-2" 
                >
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label class="form-label">{{__('SMTP Username')}}</label>
                <input 
                    required 
                    type="text" 
                    name="smtp_username"
                    value="{{$smtp->username}}"
                    placeholder="Your smtp username"
                    class="form-control px-2" 
                >
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label class="form-label">{{__('SMTP Password')}}</label>
                <input 
                    required 
                    type="password" 
                    name="smtp_password"
                    value="{{$smtp->password}}"
                    placeholder="Your smtp password"
                    class="form-control px-2" 
                >
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label class="form-label">{{__('Sender Email Address')}}</label>
                <input 
                    required 
                    type="text" 
                    name="mail_from_address"
                    value="{{$smtp->sender_email}}"
                    placeholder="Sender email address"
                    class="form-control px-2" 
                >
            </div>

            <div class="col-12 col-md-6 mb-4">
                <label class="form-label">{{__('Sender Name')}}</label>
                <input 
                    required 
                    type="text" 
                    name="mail_from_name"
                    value="{{$smtp->sender_name}}"
                    placeholder="Email seder name"
                    class="form-control px-2" 
                >
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">{{__('SMTP Encryption')}}</label>
                <select name="smtp_encryption" class="form-control px-2">
                    <option 
                        value="tls" 
                        @if($smtp->encryption == 'tls') selected @endif
                    >
                        {{__('TLS')}}
                    </option>
                    <option 
                        value="ssl" 
                        @if($smtp->encryption == 'ssl') selected @endif
                    >
                        {{__('SSL')}}
                    </option>
                </select>
            </div>
        </div>
        
        <button 
            type="submit" 
            class="mt-3 px-3 btn btn-primary"
        >
            {{__('Save Changes')}}
        </button>
    </form>
</div>