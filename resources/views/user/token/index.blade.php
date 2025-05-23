@extends('layouts.app')

@section('content')
<div class="auth-page-wrapper pt-5">
    <x-card title="Reedem Your Token">
        <form method="POST">
            @csrf
            <x-input label="Token" type="text" name="token" id="token" />
            <button type="submit" class="btn btn-primary mt-2 px-5">Submit</button>
        </form>
    </x-card>

    <x-card title='<span class="text-danger">Test Rules & Guidelines</span>'>
        <ol>
            <li>Test Duration
                <ul>
                    <li>Listening Section: 45 minutes</li>
                    <li>Reading Section: 75 minutes</li>
                </ul>
            </li>
            <li>
                Test Format
                <ul>
                    <li>The TOEIC test is divided into two sections: Listening and Reading.</li>
                    <li>Listening: In this section, you will listen to recordings and answer questions based on them.</li>
                    <li>Reading: In this section, you will read passages and answer related questions.</li>
                </ul>
            </li>
            <li>
                Time Management
                <ul>
                    <li>Once the test starts, you must complete both sections within the allotted time (45 minutes for Listening and 75 minutes for Reading).</li>
                    <li>Breaks: There are no breaks during the test. Please ensure you are ready to take the entire test without interruptions.</li>
                </ul>
            </li>
        </ol>
    </x-card>
</div>
@endsection
