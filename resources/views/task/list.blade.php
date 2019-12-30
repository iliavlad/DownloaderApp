        @if($tasks->isEmpty())

        <p id="notasks">No tasks</p>
        @else

        <table id="tasklist">
            <tr>
                <th>Id</th>
                <th>Url</th>
                <th>Status</th>
                <th>Added by</th>
                <th>Local path</th>
                <th>Created at</th>
                <th>Updated at</th>
            </tr>
            @foreach ($tasks as $task)

            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->url }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->added_by }}</td>
                <td>@if($task->local_path)<a href="{{ $task->local_path }}">{{ $task->getFileNameFromUrl() }}</a>@endif</td>
                <td>{{ $task->created_at }}</td>
                <td>{{ $task->updated_at }}</td>
            </tr>

            @endforeach

        </table>
        @endif
