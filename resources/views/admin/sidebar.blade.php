<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div id="navBar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                {{-- <div class="profile-image">
                  <img src="images/faces/face1.jpg" alt="profile image">
                </div> --}}
                <div class="text-wrapper">
                  <p class="profile-name">{{Auth::user()->name}}</p>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.home')}}">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">CQ Account</span>
            </a>
          </li>


          <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-transaction" aria-expanded="false" aria-controls="ui-category">
                <i class="menu-icon mdi mdi-chart-line"></i>
                <span class="menu-title">Transactions</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-transaction">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('transactions.index')}}">Transactions List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('transactions.create',['type'=>1])}}">Add Income</a>
                            </li>
                  <li class="nav-item">
                  <a class="nav-link" href="{{route('transactions.create',['type'=>2])}}">Add Expend</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('transactions.create',['type'=>3])}}">Add Assets</a>
                    </li>
                </ul>
              </div>
            </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-category" aria-expanded="false" aria-controls="ui-category">
              <i class="menu-icon mdi mdi-shape-outline"></i>
              <span class="menu-title">Categories</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-category">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                <a class="nav-link" href="{{route('categories.index')}}">List</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="{{route('categories.create')}}">Add Category</a>
                </li>
              </ul>
            </div>
          </li>
             

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-customer" aria-expanded="false" aria-controls="ui-category">
              <i class="menu-icon mdi mdi-account-outline"></i>
              <span class="menu-title">Customers</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-customer">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                <a class="nav-link" href="{{route('customers.index')}}">List Customer</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="{{route('customers.create')}}">Add Customer</a>
                </li>
              </ul>
            </div>
          </li>
          
        </ul>
    </div>
      </nav>