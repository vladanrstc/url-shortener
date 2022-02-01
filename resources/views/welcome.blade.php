@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add a new URL</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('urls') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="url" class="form-label">Your URL</label>
                            <input type="text" name="original_link" class="form-control" id="url" aria-describedby="url">
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" onchange="show_days(this.value)" type="radio" checked name="expiration_choice" id="inlineRadio1" value="days">
                            <label class="form-check-label" for="inlineRadio1">Expire after number of days</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" onchange="show_visits()" type="radio" name="expiration_choice" id="inlineRadio2" value="visits">
                            <label class="form-check-label" for="inlineRadio2">Expire after a number of visits</label>
                        </div>

                        <div id="expires_in_visits" class="mb-3" style="display: none">
                            <label for="url" class="form-label">Number of allowed visits</label>
                            <input type="number" name="number_of_allowed_visits" class="form-control" value="1" id="number_of_visits" aria-describedby="url" style="max-width: 100px">
                        </div>

                        <select id="expires_in_days" class="form-select mt-3" name="expires_in_days" aria-label="Expires in days" style="max-width: 100px">
                            <option selected value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                        </select>

                        <button type="submit" class="btn btn-primary mt-3">Get Link</button>

                        @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    function show_visits(str){
        document.querySelector('#expires_in_days').style.display = 'none';
        document.querySelector('#expires_in_visits').style.display = 'block';
    }
    function show_days(sign){
        document.querySelector('#expires_in_days').style.display = 'block';
        document.querySelector('#expires_in_visits').style.display = 'none';
    }
</script>
