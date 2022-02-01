@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">My urls</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Original link</th>
                                    <th scope="col">Generated link</th>
                                    <th scope="col">Date of expiration</th>
                                    <th scope="col"># of visits allowed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($urls as $url)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $url->original_link }}</td>
                                        <td>{{ $url->generated_link }}</td>
                                        <td>{{ $url->date_of_expiration ?? "/" }}</td>
                                        <td>{{ $url->number_of_allowed_visits ?? "/" }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
