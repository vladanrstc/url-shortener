@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Link Added!</div>

                    <div class="card-body">
                        <strong>Your URL is:</strong> {{ $url->generated_link }}<br>
                        <button id="copy-to-clipboard" class="btn btn-primary mt-3" type="button">Copy link to clipboard</button><br>
                        <a href="/" class="btn btn-primary mt-3">Add another one!</a>
                    </div>

                    <input id="link-value" type="text" hidden value="{{ $url->generated_link }}">

                </div>
            </div>
        </div>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        document.addEventListener('DOMContentLoaded', init, false);
        function init(){
            function message () {

                var copyText = document.getElementById("link-value");

                /* Select the text field */
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */

                /* Copy the text inside the text field */
                navigator.clipboard.writeText(copyText.value);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Copied to clipboard'
                })
            }
            document.getElementById('copy-to-clipboard').addEventListener('click', message, true);
        };
    </script>
@endsection

