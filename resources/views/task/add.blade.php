        <form action="{{ route('task.add') }}" method="post">
            <label for="url">Url</label>
            <input type="text" name="url">
            <input type="submit" value="Add">
        </form>
        @if ($errors->any())

        <div>
            <ul>
            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>
            @endforeach

            </ul>
        </div>
        @endif
