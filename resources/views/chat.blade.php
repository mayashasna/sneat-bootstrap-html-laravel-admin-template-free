@extends('layouts/contentNavbarLayout')

@section('title', __('chat.title'))

@section('page-style')
<style>
    /* ===== Service Card ===== */
    #serviceCard {
        display: none;
        border: 1px solid #e0e0e8;
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 14px;
        background: linear-gradient(135deg, #f7f7ff, #eef0ff);
        box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    }
    #serviceCard .svc-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    #serviceCard .svc-title {
        font-weight: 800;
        font-size: 17px;
        color: #2b2f48;
        margin: 0;
    }
    #serviceCard .svc-loc {
        font-size: 13px;
        color: #777;
        margin-top: 2px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    #serviceCard .svc-price {
        font-weight: 800;
        font-size: 16px;
        color: #6a5af9;
        white-space: nowrap;
    }
    #serviceCard .svc-type {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        background: #28c76f;
    }
    #serviceCard .svc-type.sale { background: #0ea5e9; }

    #messages {
        border:1px solid #ccc;
        padding:10px;
        height:300px;
        overflow-y:scroll;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .msg {
        padding: 8px 12px;
        max-width: 60%;
        border-radius: 10px;
        font-size: 15px;
        width: fit-content;
    }

    .me {
        background: #d1ffd1;
        margin-left: auto;
        text-align: right;
    }

    .other {
        background: #f1f1f1;
        margin-right: auto;
        text-align: left;
    }

    .meta {
        font-size: 11px;
        color: #777;
        margin-top: 3px;
        text-align: right;
    }
</style>
@endsection

@section('content')

<h2>{{ __('chat.realtime_test') }}</h2>

{{-- Service Card --}}
<div id="serviceCard">
    <div class="svc-row">
        <div>
            <p class="svc-title" id="svcTitle"></p>
            <div class="svc-loc">
                <i class="bx bx-map"></i>
                <span id="svcLocation"></span>
            </div>
        </div>
        <div style="text-align:end;">
            <span class="svc-type" id="svcType"></span>
            <div class="svc-price" id="svcPrice"></div>
        </div>
    </div>
</div>

<div id="messages"></div>

<br>

<button onclick="markAsRead()" class="btn btn-primary">
    {{ __('chat.mark_read') }}
</button>

@endsection

@section('page-script')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<script>

    // -----------------------------
    // 1) Load token + user
    // -----------------------------
    const token = localStorage.getItem("token");

    if (!token) {
        alert("{{ __('chat.no_token') }}");
        window.location.href = "/login.html";
    }

    let userId = null;
    try {
        const userJson = localStorage.getItem("user");
        if (userJson) {
            const user = JSON.parse(userJson);
            userId = user?.id ?? null;
        }
    } catch (e) {
        userId = null;
    }

    // -----------------------------
    // 2) Setup Pusher
    // -----------------------------
    Pusher.logToConsole = true;

    const pusher = new Pusher("72739a0672f9a4022fe0", {
        cluster: "mt1",
        encrypted: true,
        authEndpoint: "http://127.0.0.1:8000/api/broadcasting/auth",
        auth: {
            headers: {
                Authorization: "Bearer " + token
            }
        }
    });

    let conversationId = null;

    // -----------------------------
    // Helper: extract array from any API shape
    // -----------------------------
    function extractList(res) {
        if (Array.isArray(res)) return res;
        if (res && Array.isArray(res.data)) return res.data;
        if (res && res.data && Array.isArray(res.data.data)) return res.data.data;
        return [];
    }

    // -----------------------------
    // Helper: render service card
    // -----------------------------
    function renderServiceCard(service) {
        if (!service) return;

        const isAr = "{{ app()->getLocale() }}" === "ar";

        // العنوان حسب اللغة
        document.getElementById("svcTitle").innerText =
            isAr ? (service.title_ar || service.title_en || "") : (service.title_en || service.title_ar || "");

        // الموقع
        document.getElementById("svcLocation").innerText = service.location_text || "";

        // السعر حسب العملة
        let price = "";
        if (service.currency === "USD") {
            price = Number(service.price_usd).toLocaleString() + " $";
        } else {
            price = Number(service.price_syp).toLocaleString() + " {{ __('chat.syp') }}";
        }
        document.getElementById("svcPrice").innerText = price;

        // نوع الخدمة (إيجار/بيع)
        const typeEl = document.getElementById("svcType");
        if (service.type === "sale") {
            typeEl.innerText = "{{ __('chat.for_sale') }}";
            typeEl.classList.add("sale");
        } else {
            typeEl.innerText = "{{ __('chat.for_rent') }}";
        }

        // أظهر البطاقة
        document.getElementById("serviceCard").style.display = "block";
    }

    // -----------------------------
    // 3) Init: load user's conversations and listen to them
    // -----------------------------
    async function initChat() {
        try {

            // 3.1) Fetch user conversations
            const res = await fetch("http://127.0.0.1:8000/api/user/conversations", {
                headers: { Authorization: "Bearer " + token }
            });

            const json = await res.json();
            const conversations = extractList(json);

            if (!conversations.length) {
                console.log("no conversations yet");
                return;
            }

            // 3.2) Listen to all conversations of this user
            conversations.forEach(c => {
                if (c && c.id) {
                    startListening(c.id);
                }
            });

            // keep last id for markAsRead button
            conversationId = conversations[0].id;

            // 3.3) Render service card of the first conversation
            renderServiceCard(conversations[0].service);

        } catch (err) {
            console.error("initChat error:", err);
        }
    }

    // -----------------------------
    // 4) Listen to conversation channel
    // -----------------------------
    function startListening(conversationId) {

        const channel = pusher.subscribe(`private-conversation.${conversationId}`);

        channel.bind_global(function(event, payload) {
            console.log("EVENT:", event, payload);

            const box = document.getElementById("messages");

            if (event === "message.read") {
                const div = document.createElement("div");
                div.classList.add("msg", "other");
                div.innerText = "{{ __('chat.read_by') }} " + payload.readerId;
                box.appendChild(div);
                box.scrollTop = box.scrollHeight;
                return;
            }

            if (payload && payload.message) {
                const wrapper = document.createElement("div");
                const div = document.createElement("div");
                div.classList.add("msg");

                if (payload.message.sender_id == userId) {
                    div.classList.add("me");
                } else {
                    div.classList.add("other");
                }

                div.innerText = payload.message.body;
                wrapper.appendChild(div);

                if (typeof payload.message.status !== "undefined") {
                    const meta = document.createElement("div");
                    meta.classList.add("meta");
                    meta.innerText =
                        payload.message.status === 'read'
                        ? "{{ __('chat.read') }}"
                        : "{{ __('chat.sent') }}";
                    wrapper.appendChild(meta);
                }

                box.appendChild(wrapper);
                box.scrollTop = box.scrollHeight;
            }
        });
    }

    // -----------------------------
    // 5) Mark conversation as read
    // -----------------------------
    async function markAsRead() {
        const response = await fetch(`http://127.0.0.1:8000/api/conversations/${conversationId}/read`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: "Bearer " + token
            }
        });

        const data = await response.json();
        console.log("read response:", data);
    }

    // -----------------------------
    // 6) Start everything
    // -----------------------------
    initChat();

</script>
@endsection
