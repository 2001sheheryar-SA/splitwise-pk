
<h2>Register</h2>


<form action="{{route('invite.register',['token' => request('token')]) }}" method="POST" enctype="multipart/form-data"> 
    {{-- <form id="inviteForm" enctype="multipart/form-data"> --}}
     {{-- @csrf --}}
    <div class="form-group">
        <label>User Name</label>
        <input type="text" name="name" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
       
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    
   
    <button type="submit" class="btn">Register</button>

    <a href="" style="margin-left: 10px;">Already have an account? Login</a>
</form>

