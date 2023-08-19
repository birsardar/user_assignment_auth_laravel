<!DOCTYPE html>
<html>
<head>
    <title>Change Task Status</title>
</head>
<body>
    <h1>Change Task Status</h1>
    <form action="/todo/status" method="post">
        @csrf
        <label>Task ID:</label>
        <input type="text" name="task_id"><br><br>
        <label>Status:</label>
        <select name="status">
            <option value="pending">Pending</option>
            <option value="done">Done</option>
        </select><br><br>
        <button type="submit">Change Status</button>
    </form>
</body>
</html>
