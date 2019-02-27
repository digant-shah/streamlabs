<div class="row">
    <div class="col-md-12">
        <table class="table channel-listing">
            <thead>
            <tr>
                <th scope="col">Logo</th>
                <th scope="col">Channel Name</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody data-subscribe-url="{{ route('subscribeToChannel') }}">
                @if(empty($channels))
                    <tr>
                        <td class="text-center" colspan="3">Nothing to display!!</td>
                    </tr>
                @else
                    @foreach($channels as $channel)
                        <tr data-channel-id="{{ $channel->channelID }}" data-channel-name="{{ $channel->name }}">
                            <td><img src="{{ $channel->logo }}" alt="{{ $channel->displayName }}" class="img-thumbnail channel-thumbnail"></td>
                            <td>{{ $channel->displayName }}</td>
                            <td><button class="btn btn-twitch subscribe-to-channel">Subscribe</button></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@if(!empty($previousURL) || !empty($nextURL))
    <div class="row">
        <div class="col-md-12">
            <nav class="float-right">
                <ul class="pagination">
                    <li class="page-item {{ empty($previousURL) ? "disabled" : ""}}">
                        <span
                                class="page-link channel-paginate"
                                @if(!empty($previousURL))
                                    data-url="{{ $previousURL }}"
                                @endif
                        >Previous</span>
                    </li>
                    <li class="page-item">
                        <span
                            class="page-link channel-paginate"
                            @if(!empty($nextURL))
                                data-url="{{ $nextURL }}"
                            @endif
                        >Next</span>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endif