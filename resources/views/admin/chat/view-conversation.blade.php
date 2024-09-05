@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
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
                                    <h1 class="card-title">Chat Dengan {{ $user->name }}</h1>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="chat-messages"
                                    style="border: 1px solid #ddd; padding: 10px; height: 400px; overflow-y: scroll;">
                                    @foreach ($messages as $message)
                                        <p><strong>{{ $message->sender->name }}:</strong> {{ $message->body }}</p>
                                    @endforeach
                                </div>

                                <form id="admin-chat-form">
                                    @csrf
                                    <textarea id="admin-chat-input" placeholder="Type your reply..." class="form-control"></textarea>
                                    <button type="submit" class="btn btn-primary mt-2">Send</button>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>

    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let userId = '{{ $userId }}';

            function loadMessages() {
                $.get('{{ route('admin.chat.fetchMessage', ['userId' => $userId]) }}', function(data) {
                    let chatMessages = $('#chat-messages');
                    chatMessages.empty();
                    console.log(data);

                    data.forEach(function(message) {
                        chatMessages.append('<p><strong>' + message.sender.name + ':</strong> ' +
                            message.body + '</p>');
                    });

                    chatMessages.scrollTop(chatMessages[0].scrollHeight);
                });
            }

            const adminId = '{{ auth()->user()->id }}';
            $('#admin-chat-form').on('submit', function(e) {
                e.preventDefault();

                let message = $('#admin-chat-input').val();
                if (message.trim() === '') return;
                $.post('{{ route('admin.chat.send', ['userId' => $userId]) }}', {
                    _token: '{{ csrf_token() }}',
                    sender_id: adminId,
                    message: message
                }, function() {
                    $('#admin-chat-input').val('');
                    loadMessages();
                });
            });

            // Initial load and refresh every 3 seconds
            loadMessages();
            setInterval(loadMessages, 3000);
        });
    </script>
@endsection
