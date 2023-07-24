<?php
$label;
$inputType;

function active($inputType, $input)
{
    return $inputType == $input ? 'active' : 'inactive';
}
?>

<div class="mb-3">
    <label for="qrName" class="form-label">{{__('Name')}}</label>
    <input id="qrName" name="name" type="text" class="form-control" placeholder="QR Code Name" required>
</div>

<div class="mb-3">
    <div class="d-flex align-items-end justify-content-between form-label">
        <label>{{__('Project Name')}}</label>
        <a href="/dashboard/project" class="btn btn-primary text-white">{{__('Create Project')}}</a>
    </div>
    <select required id="projectId" class="form-select">
        <option selected disabled value="" class="d-none">{{__('Select Project')}}</option>
        @foreach ($projects as $project)
            <option value="{{ $project->id }}">
                {{ $project->project_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">{{__('QR Type')}}</label>
    <select required id="QRType" class="form-select">
        <option disabled selected value="" class="d-none">{{__('Select QR Type')}}</option>
        <option value="textarea">{{__('Text Content')}}</option>
        <option value="text">{{__('URL Address')}}</option>
        <option value="email">{{__('Email Address')}}</option>
        <option value="number">{{__('Phone Number')}}</option>
    </select>
</div>
<div id="qrContentBox" class="mt-3">
    <label for="qrContent" class="form-label">{{__('Type Content')}}</label>
    <textarea rows="4" disabled id="qrContent" class="form-control opacity-50" placeholder="Type text content"></textarea>
</div>
