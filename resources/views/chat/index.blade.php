@extends('user.layouts.app')

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
                                <h1 class="card-title">Chat Dengan Admin</h1>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
    <div id="chat-messages" style="border: 1px solid #ddd; padding: 10px; height: 400px; overflow-y: scroll;">
        <!-- Messages will be loaded here -->
    </div>

    <form id="chat-form">
        @csrf
        <textarea id="chat-input" placeholder="Type your message..." class="form-control"></textarea>
        <button type="submit" class="btn btn-primary mt-2">Send</button>
        <input type="hidden" id="admin-id" value="{{ $adminId }}">
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


@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function loadMessages() {
            $.get('{{ route('chat.messages') }}', function(data) {
                let chatMessages = $('#chat-messages');
                chatMessages.empty();

                data.forEach(function(message) {
                    chatMessages.append('<p><strong>' + message.user.name + ':</strong> ' + message.body + '</p>');
                });

                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            });
        }

        $('#chat-form').on('submit', function(e) {
            e.preventDefault();

            let message = $('#chat-input').val();
            if (message.trim() === '') return;

            $.post('{{ route('chat.send') }}', {
                _token: '{{ csrf_token() }}',
                message: message,
                admin_id: $('#admin-id').val(),
                sender_id: '{{ auth()->id() }}'
            }, function() {
                $('#chat-input').val('');
                loadMessages();
            });
        });

        // Initial load and refresh every 3 seconds
        loadMessages();
        setInterval(loadMessages, 3000);
    });
</script>
@endsection