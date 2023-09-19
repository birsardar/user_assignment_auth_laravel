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
                            <button class="change-status" data-task-id="{{ $task->id }}">
                                Mark Done
                            </button>
                        @else
                            <!-- Show a disabled button if the task is already done -->
                            <button disabled>Done</button>
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
                            newRow.append('<td><button class="change-status" data-task-id="' +
                                response.task.id + '">Mark Done</button></td>');
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

            // Handle the "Mark Done" button click event using event delegation
            $('table').on('click', '.change-status', function() {
                var button = $(this);
                var taskId = button.data('task-id');
                var apiKey = 'helloatg';

                $.ajax({
                    type: 'POST',
                    url: '/api/todo/status',
                    data: {
                        task_id: taskId,
                        status: 'done',
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'API_KEY': apiKey,
                    },
                    success: function(response) {
                        // Update the UI to reflect the changed status
                        if (response.status === 1) {
                            // Update the status in the table cell
                            button.closest('tr').find('td:nth-child(3)').text('done');

                            // Disable the button since the task is now done
                            button.prop('disabled', true);
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
