<?php
namespace Views;

class TasksView {
    public function showTasks($tasks) {
        echo "<div class='task-list-container'>";
        echo "<h1>Task List</h1>";
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                </tr>";
        foreach ($tasks as $task) {
            echo "<tr>
                    <td>{$task['id']}</td>
                    <td>{$task['title']}</td>
                    <td>{$task['description']}</td>
                    <td>{$task['due_date']}</td>
                    <td>{$task['priority']}</td>
                    <td>{$task['status']}</td>
                </tr>";
        }
        echo "</table>";
        echo "</div>";
    }
}