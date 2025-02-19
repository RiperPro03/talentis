<div class="navbar bg-white shadow-lg">
  <div class="flex-1">
    <a class="btn btn-ghost text-xl" href="#">
      <img src="{{ asset('./img/logo/logo.png') }}" class="h-8 w-auto mr-2 rounded-ful" alt="Logo">
      Talentis
    </a>
  </div>
  <div class="flex-none gap-2">
    <div class="form-control">
      <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
    </div>
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img
            alt="Logo"
            src="{{ asset('./img/test/photo.png') }}" />
        </div>
      </div>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-white rounded-box z-[1] mt-3 w-52 p-2 shadow">
        <li>
          <a class="justify-between">
            Profile
            <span class="badge">New</span>
          </a>
        </li>
        <li><a>Settings</a></li>
        <li><a>Logout</a></li>
      </ul>
    </div>
  </div>
</div>