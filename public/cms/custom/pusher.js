Pusher.logToConsole = true;
const branchId = $("#branchManager").val();
if(branchId != 0) {
    const pusher = new Pusher($("#pusherKey").val(), {
        cluster: $("#pusherCluster").val(),
        encrypted: true
    });
    const channel = pusher.subscribe('branchNotification.' + branchId);
    channel.bind('BranchNotification', function (data) {
        console.log("Order received:" + JSON.stringify(data));
        const curr = parseInt($("#notificationNumber").text()) || 0;
        $(".changenumber").text(curr + 1);
        $("#appendNotification").prepend(`
                        <a href="${data.url}">
                                         <div class="media">
                                        <div class="media-left align-self-center"><i class="${data.icons}"></i></div>
                                        <div class="media-body">
                                            <h6 class="media-heading">${data.message1}</h6>
                                            <p class="notification-text font-small-3 text-muted"> ${data.message2}</p>
                                        </div>
                                    </div>
                        </a>
                    `);

    });
}
