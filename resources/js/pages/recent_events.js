import { MAX_EVENTS_SHOWN } from "../app_config";

const recentEventsClass = ".recent-events",
      channelName = $("meta[name='channel_name']").attr("content");

window.Echo
    .channel("user-got-followers")
    .listen(
        "UserGotFollower",
        function(event) {
            let data = event.receivedData.data[0],
                $recentEvents = $(recentEventsClass);

            if($recentEvents.children().length >= MAX_EVENTS_SHOWN) {
                $recentEvents.children().first().remove();
            }

            $recentEvents.append(
                `<span>${data.from_name} just followed ${channelName}</span><br>`
            )
        }
    );