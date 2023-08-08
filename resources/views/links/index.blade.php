<!DOCTYPE html>
<html>
<head>
    <title>Shark App</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Create short link</h1>

    <!-- if there are creation errors, they will show here -->
    {{ Html::ul($errors->all()) }}

    {{-- Create short link form --}}
    {{ Form::open([
    'url' => $create_url,
    'id' => 'generate_form'
    ]) }}

    {{-- Name input --}}
    <div class="form-group">
        {{ Form::label('name', $labels['name']) }}
        {{ Form::text('name', '', [
    'class' => 'form-control',
    'id' => 'input_name'
    ]) }}
    </div>

    {{-- Url input --}}
    <div class="form-group">
        {{ Form::label('url', $labels['url']) }}
        {{ Form::url('url', '', [
    'class' => 'form-control',
    'id' => 'input_url'
    ]) }}
    </div>

    {{-- Limit input --}}
    <div class="form-group">
        {{ Form::label('limit', $labels['limit']) }}
        {{ Form::number('limit', $link->limit, [
    'class' => 'form-control',
    'min' => 0,
    'id' => 'input_limit'
    ]) }}
    </div>

    {{-- Valid hours input --}}
    <div class="form-group">
        {{ Form::label('valid_hours', $labels['valid_hours']) }}
        {{ Form::number('valid_hours', $link->valid_hours, [
    'class' => 'form-control',
    'min' => 1,
    'max' => 24,
    'id' => 'input_valid_hours'
    ]) }}
    </div>


    <div class="row">
        {{-- Submit button --}}
        <div class="col-lg-4 text-left">
            {{ Form::submit('Create short link!', array('class' => 'btn btn-primary btn-block')) }}
        </div>
        <div class="col-lg-4 text-right">
            &nbsp;
        </div>
        {{-- Reset button --}}
        <div class="col-lg-4 text-right">
            <button class="btn btn-secondary btn-block" id="reset_button">Reset form</button>
        </div>
    </div>
    {{ Form::close() }}

{{-- Container for short link --}}
    <div class="container message-container" title="Click to copy...">
        <div class="alert alert-info" role="alert" hidden="hidden" id="for_short_link"></div>
    </div>

</div>

</body>
</html>

<!-- Custom script add -->
<script src="{{ asset('js/index.js') }}" defer></script>

