@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">Welcome, {{ Auth::user()->name }}</h1>
            </div>
        </div>
    </div>
    <form id="add-task-form">
        <input type="text" id="task-name" placeholder="Enter task name" />
        <button type="submit">Add Task</button>
    </form>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Task</th>
                <th scope="col">Status</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $key => $task)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $task->task }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->created_at }}</td>
                    <td>
                        @if ($task->status === 'pending')
                            <button class="btn btn-success change-status" data-task-id="{{ $task->id }}"
                                data-new-status="done">
                                Mark Done
                            </button>
                        @else
                            <button class="btn btn-danger change-status" data-task-id="{{ $task->id }}"
                                data-new-status="pending">
                                Mark Pending
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-task-form').on('submit', function(e) {
                e.preventDefault();
                var task = $('#task-name').val();
                var status = 'pending';
                var apiKey = 'helloatg';
                var user_id = {{ Auth::user()->id }};

                $.ajax({
                    type: 'POST',
                    url: '/api/todo/add',
                    data: {
                        task: task,
                        status: status,
                        user_id: user_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'API_KEY': apiKey,
                    },
                    success: function(response) {
                        // Update the UI to show the newly added task
                        if (response.status === 1) {
                            var newRow = $('<tr>');
                            newRow.append('<th scope="row">' + ($('table tbody tr').length +
                                    1) +
                                '</th>');
                            newRow.append('<td>' + task + '</td>');
                            newRow.append('<td>' + status + '</td>');
                            newRow.append('<td>' + response.task.created_at + '</td>');
                            newRow.append(
                                '<td><button class="change-status btn btn-success" data-task-id="' +
                                response.task.id +
                                '" data-new-status="done">Mark Done</button></td>');
                            $('table tbody').append(newRow);

                            // Clear the input fields after adding the task
                            $('#task-name').val('');
                        } else {
                            console.log('Task not added. API response:', response);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // Handle the "Mark Done" and "Mark Pending" button click events using event delegation
            $('table').on('click', '.change-status', function() {
                var button = $(this);
                var taskId = button.data('task-id');
                var newStatus = button.data('new-status');
                var apiKey = 'helloatg';

                $.ajax({
                    type: 'POST',
                    url: '/api/todo/status',
                    data: {
                        task_id: taskId,
                        status: newStatus,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'API_KEY': apiKey,
                    },
                    success: function(response) {
                        // Update the UI to reflect the changed status
                        if (response.status === 1) {
                            // Update the status in the table cell
                            var statusCell = button.closest('tr').find('td:nth-child(3)');
                            statusCell.text(newStatus.charAt(0) + newStatus.slice(
                                1));

                            // Update the button color based on the new status
                            if (newStatus === 'done') {
                                button.removeClass('btn-success').addClass('btn-danger');
                                button.text('Mark Pending');
                                button.data('new-status', 'pending');
                            } else {
                                button.removeClass('btn-danger').addClass('btn-success');
                                button.text('Mark Done');
                                button.data('new-status', 'done');
                            }
                        } else {
                            console.log('Status not updated. API response:', response);
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection
