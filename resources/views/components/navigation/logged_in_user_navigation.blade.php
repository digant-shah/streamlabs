<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route("showHomePage") }}">Home</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <a href="{{ route("logout") }}" title="Logout {{ getDisplayName() }}?">Logout</a>
        </ul>
    </div>
</nav>