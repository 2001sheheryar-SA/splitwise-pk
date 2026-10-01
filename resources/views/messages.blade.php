 @vite(['resources/css/app.css', 'resources/js/app.js']);
@extends('layouts.app')

@section('content')
<h2>Send Message </h2>


<form action="{{ route('sendmessage') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Message</label>
        <input type="text" name="msg" required>
    </div>
    

    <button type="submit" class="btn">Send</button>
    {{-- <a href="" style="margin-left: 10px;">Show Products</a> --}}

  {{-- <a href="{{route('showproducts')}}" style="margin-left: 10px;">Show Products</a>  --}}
  <a href="{{route('dashboard')}}" class="btn" style="margin-left: 20px;">Dashboard</a> 
</form>



<table>
    <thead>
        <tr>
            <th>Sender</th>
            <th>Message</th>
            <
        </tr>
    </thead>
    <tbody>
        @forelse($messages as $messages)
        <tr>
            
            <td>{{ $messages->sender_id }}</td>
            <td>{{ $messages->msg }}</td>
           
        </tr>
        @empty
            <tr>
                <td colspan="2">No messages found in the database.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection



<script type="module">
console.log(window.Echo);
 window.Echo.channel('test-channel')
            .listen('.TestEvent', (e) => {
                console.log('Received:',e);
               
                const tableBody = document.querySelector('table tbody');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>${e.senderid}</td>
                    <td>${e.msg}</td>
                `;

                // Append the new message to the table
                tableBody.appendChild(newRow); 
                });

   
</script>