@extends('admin.layouts.app')

@section('styles')
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Chat</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Chat</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <h1 class="card-title">Chat Dengan Pengguna</h1>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <!-- Search Form -->
                                <form action="{{ route('admin.chat.index') }}" method="GET" class="mb-4">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search by username or email" value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- User Cards -->
                                <div class="row">
                                    @foreach ($users as $user)
                                        <div class="col-md-4">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $user->name }}</h5><br>
                                                    @if ($user->has_unreplied_message)
                                                        <span class="badge badge-danger">Ada Pesan Yang Belum Dibalas</span>
                                                    @endif
                                                    <p class="card-text">{{ $user->email }}</p>
                                                    <a href="{{ route('admin.chat.viewConversation', $user->id) }}"
                                                        class="btn btn-primary">Chat</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination Links -->
                                <div class="d-flex justify-content-center">
                                    {{ $users->links() }}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            <!-- /.row (main row) -->
        </section>

    </div>
@endsection
