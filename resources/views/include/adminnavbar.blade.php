<style>
    .bg-brown {
        background: rgb(250, 167, 43);
    }

    .abs-side-navbar {
        position: fixed;
        background: rgb(250, 167, 43);
        height: 100%;
        top: 0;
        left: 0;
        padding: 7px 0px;
        width: 15.5em;
        z-index: 20;
    }

    .abs-side-navbar .abs-nav-brand {
        padding: 7px 12px;
        /* background: greenyellow; */
        display: flex;
        justify-content: flex-start;
        align-items: center;
        margin-top: 2.1em;
    }

    .abs-side-navbar .abs-nav {
        margin-top: 2em;
    }

    .abs-side-navbar .abs-nav .abs-nav-item {
        display: block;
        /* background: rgb(46, 43, 43); */
        padding: 1px;
        margin-top: 7px;
    }

    .abs-side-navbar .abs-nav .abs-nav-link {
        display: block;
        padding: 9px;
        padding-left: 2em;
        transition: .5s transform;
        margin: 2px 14px;
        color: white;
        font-size: 17px;
        font-weight: 500;
    }

    .abs-side-navbar .abs-nav .abs-nav-link .icon {
        margin-right: .7rem;
    }

    .abs-side-navbar .abs-nav .abs-nav-link.active {
        background: white;
        border-radius: 20px;
        color: black;
    }

    .abs-side-navbar .abs-nav .abs-nav-link:hover {
        text-decoration: none;
        transform: translateX(1em);
    }

    .main {
        margin-left: 15em;
        padding: 7px;
    }

    @media screen and (max-width: 1148px) {
        .abs-side-navbar {
            position: sticky;
            padding: 7px 0px;
            width: 100%;
            ;
        }

        .abs-side-navbar .abs-nav-brand {
            /* padding: 7px 12px; */
            justify-content: space-between;
            align-items: center;
            margin-top: 0;
        }

        .abs-side-navbar .abs-nav {
            display: none;
        }

        .main {
            margin-left: 0;
        }
    }

</style>
<div class="abs-side-navbar">
    <div class="abs-nav-brand ml-1">
        <button type="button" class="btn mr-2 text-white">
            <i class="fas fa-bars fa-lg"></i>
        </button>
        <h5 class="ml-1 font-weight-bold text-white">
            CLEARANCE
        </h5>
    </div>
    <div class="abs-nav">
        <ul class="list-unstyled">
            <li class="abs-nav-item">
                <a href="/admin/dashboard" class="abs-nav-link @if ($title == 'Dashboard') active @endif">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span>
                    Dashboard
                </a>
            </li>
            <li class="abs-nav-item">
                <a href="/admin/students/nd2" class="abs-nav-link @if ($title == 'Students') active @endif">
                    <span class="icon">
                        <i class="fas fa-graduation-cap"></i>
                    </span>
                    Students
                </a>
            </li>
            <li class="abs-nav-item">
                <a href="/admin/settings" class="abs-nav-link @if ($title == 'Settings') active @endif">
                    <span class="icon">
                        <i class="fas fa-cog"></i>
                    </span>
                    Settings
                </a>
            </li>
            <li class="abs-nav-item">
                <a href="/admin/logout" class="abs-nav-link @if ($title == 'Logout') active @endif">
                    <span class="icon">
                        <i class="fas fa-power-off"></i>
                    </span>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>
