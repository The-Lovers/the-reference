@php
    $chatCurrentUser = Auth::user();
@endphp

<div
    id="internalChatApp"
    class="internal-chat-app"
    data-panel-url="{{ route('chat.panel', ['locale' => app()->getLocale()]) }}"
    data-show-url-template="{{ route('chat.show', ['locale' => app()->getLocale(), 'user' => '__USER__']) }}"
    data-store-url-template="{{ route('chat.store', ['locale' => app()->getLocale(), 'user' => '__USER__']) }}"
    data-csrf="{{ csrf_token() }}"
    data-loading-text="{{ __('dashboard.chat.loading') }}"
    data-empty-title="{{ __('dashboard.chat.empty-title') }}"
    data-empty-text="{{ __('dashboard.chat.empty-text') }}"
    data-no-conversation="{{ __('dashboard.chat.no-conversation') }}"
    data-send-text="{{ __('dashboard.chat.send') }}"
    data-you-text="{{ __('dashboard.chat.you') }}"
>
    <button type="button" class="internal-chat-fab" id="internalChatToggle" aria-label="{{ __('dashboard.chat.open') }}">
        <i class="fa-regular fa-comments"></i>
        <span class="internal-chat-fab-badge d-none" id="internalChatFabBadge">0</span>
    </button>

    <div class="internal-chat-panel d-none" id="internalChatPanel">
        <div class="internal-chat-panel-head">
            <div>
                <h5>{{ __('dashboard.chat.title') }}</h5>
                <p>{{ __('dashboard.chat.subtitle') }}</p>
            </div>
            <button type="button" class="internal-chat-close" id="internalChatClose" aria-label="{{ __('dashboard.chat.close') }}">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="internal-chat-layout">
            <aside class="internal-chat-sidebar">
                <div class="internal-chat-start">
                    <label for="internalChatUserSelect" class="internal-chat-label">{{ __('dashboard.chat.new-chat') }}</label>
                    <div class="internal-chat-start-row">
                        <select id="internalChatUserSelect" class="form-select">
                            <option value="">{{ __('dashboard.chat.select-user') }}</option>
                        </select>
                        <button type="button" class="btn third" id="internalChatStartButton">{{ __('dashboard.chat.start-chat') }}</button>
                    </div>
                </div>

                <div class="internal-chat-search">
                    <input type="text" id="internalChatSearch" class="form-control" placeholder="{{ __('dashboard.chat.search-placeholder') }}">
                </div>

                <div class="internal-chat-section-title">{{ __('dashboard.chat.recent-conversations') }}</div>
                <div class="internal-chat-conversations" id="internalChatConversationList">
                    <div class="internal-chat-placeholder">{{ __('dashboard.chat.loading') }}</div>
                </div>
            </aside>

            <section class="internal-chat-thread">
                <div class="internal-chat-empty" id="internalChatEmptyState">
                    <div class="internal-chat-empty-icon"><i class="fa-regular fa-envelope-open"></i></div>
                    <h6>{{ __('dashboard.chat.empty-title') }}</h6>
                    <p>{{ __('dashboard.chat.empty-text') }}</p>
                </div>

                <div class="internal-chat-thread-shell d-none" id="internalChatThreadShell">
                    <div class="internal-chat-thread-head">
                        <div class="internal-chat-thread-user">
                            <img src="{{ $chatCurrentUser->avatar_url }}" alt="chat-user" id="internalChatThreadAvatar">
                            <div>
                                <h6 id="internalChatThreadName"></h6>
                                <span id="internalChatThreadEmail"></span>
                            </div>
                        </div>
                    </div>

                    <div class="internal-chat-messages" id="internalChatMessages"></div>

                    <form id="internalChatForm" class="internal-chat-form">
                        <textarea id="internalChatMessageInput" class="form-control" rows="3" placeholder="{{ __('dashboard.chat.message-placeholder') }}"></textarea>
                        <button type="submit" class="btn success">{{ __('dashboard.chat.send') }}</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const app = document.getElementById('internalChatApp');

        if (!app) {
            return;
        }

        const state = {
            activeUserId: null,
            conversations: [],
            users: [],
            thread: [],
            poller: null,
        };

        const panelUrl = app.dataset.panelUrl;
        const csrfToken = app.dataset.csrf;
        const showUrlTemplate = app.dataset.showUrlTemplate;
        const storeUrlTemplate = app.dataset.storeUrlTemplate;

        const toggle = document.getElementById('internalChatToggle');
        const closeButton = document.getElementById('internalChatClose');
        const panel = document.getElementById('internalChatPanel');
        const fabBadge = document.getElementById('internalChatFabBadge');
        const conversationList = document.getElementById('internalChatConversationList');
        const userSelect = document.getElementById('internalChatUserSelect');
        const searchInput = document.getElementById('internalChatSearch');
        const startButton = document.getElementById('internalChatStartButton');
        const emptyState = document.getElementById('internalChatEmptyState');
        const threadShell = document.getElementById('internalChatThreadShell');
        const threadAvatar = document.getElementById('internalChatThreadAvatar');
        const threadName = document.getElementById('internalChatThreadName');
        const threadEmail = document.getElementById('internalChatThreadEmail');
        const messagesBox = document.getElementById('internalChatMessages');
        const messageInput = document.getElementById('internalChatMessageInput');
        const form = document.getElementById('internalChatForm');
        const headerBadge = document.getElementById('chatHeaderBadge');
        const dropdownList = document.getElementById('chatDropdownList');

        const text = {
            loading: app.dataset.loadingText,
            emptyTitle: app.dataset.emptyTitle,
            emptyText: app.dataset.emptyText,
            noConversation: app.dataset.noConversation,
            you: app.dataset.youText,
        };

        const escapeHtml = (value) => {
            const div = document.createElement('div');
            div.textContent = value || '';
            return div.innerHTML;
        };

        const replaceUserInUrl = (template, userId) => template.replace('__USER__', userId);

        const updateUnreadBadges = (count) => {
            if (headerBadge) {
                headerBadge.textContent = count;
                headerBadge.classList.toggle('d-none', count < 1);
            }

            fabBadge.textContent = count;
            fabBadge.classList.toggle('d-none', count < 1);
        };

        const renderUserSelect = () => {
            const currentValue = userSelect.value;
            userSelect.innerHTML = `<option value="">${escapeHtml('{{ __('dashboard.chat.select-user') }}')}</option>`;

            state.users.forEach((user) => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = `${user.name} (${user.email})`;
                userSelect.appendChild(option);
            });

            if ([...userSelect.options].some((option) => option.value === currentValue)) {
                userSelect.value = currentValue;
            }
        };

        const renderDropdown = () => {
            if (!dropdownList) {
                return;
            }

            if (!state.conversations.length) {
                dropdownList.innerHTML = `
                    <div class="notifications-item">
                        <div class="notifications-desc w-100">
                            <span class="font-body text-muted">{{ __('dashboard.header.messages.empty') }}</span>
                        </div>
                    </div>
                `;
                return;
            }

            dropdownList.innerHTML = state.conversations.slice(0, 8).map((conversation) => `
                <button type="button" class="notifications-item w-100 text-start chat-dropdown-item ${conversation.unread_count > 0 ? 'notification-unread' : ''}" data-chat-user-id="${conversation.user.id}">
                    <div class="notifications-desc w-100">
                        <span class="fw-semibold text-dark">${escapeHtml(conversation.user.name)}</span>
                        <div class="font-body text-muted text-truncate">${escapeHtml(conversation.last_message || '')}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="notifications-date text-muted border-bottom border-bottom-dashed">${escapeHtml(conversation.last_message_at || '')}</div>
                            ${conversation.unread_count > 0 ? `<span class="internal-chat-inline-badge">${conversation.unread_count}</span>` : ''}
                        </div>
                    </div>
                </button>
            `).join('');

            dropdownList.querySelectorAll('.chat-dropdown-item').forEach((item) => {
                item.addEventListener('click', function () {
                    const userId = this.dataset.chatUserId;
                    openPanel();
                    loadConversation(userId);
                });
            });
        };

        const renderConversations = () => {
            const filter = searchInput.value.trim().toLowerCase();
            const items = state.conversations.filter((conversation) => {
                const haystack = `${conversation.user.name} ${conversation.user.email} ${conversation.last_message || ''}`.toLowerCase();
                return haystack.includes(filter);
            });

            if (!items.length) {
                conversationList.innerHTML = `<div class="internal-chat-placeholder">${escapeHtml(text.noConversation)}</div>`;
                return;
            }

            conversationList.innerHTML = items.map((conversation) => `
                <button type="button" class="internal-chat-conversation-item ${Number(state.activeUserId) === Number(conversation.user.id) ? 'is-active' : ''}" data-user-id="${conversation.user.id}">
                    <img src="${escapeHtml(conversation.user.avatar_url)}" alt="${escapeHtml(conversation.user.name)}">
                    <div class="internal-chat-conversation-content">
                        <div class="internal-chat-conversation-top">
                            <strong>${escapeHtml(conversation.user.name)}</strong>
                            <span>${escapeHtml(conversation.last_message_at || '')}</span>
                        </div>
                        <div class="internal-chat-conversation-bottom">
                            <p>${escapeHtml(conversation.last_message || '')}</p>
                            ${conversation.unread_count > 0 ? `<span class="internal-chat-inline-badge">${conversation.unread_count}</span>` : ''}
                        </div>
                    </div>
                </button>
            `).join('');

            conversationList.querySelectorAll('.internal-chat-conversation-item').forEach((item) => {
                item.addEventListener('click', function () {
                    loadConversation(this.dataset.userId);
                });
            });
        };

        const renderMessages = (messages) => {
            if (!messages.length) {
                messagesBox.innerHTML = `<div class="internal-chat-placeholder">${escapeHtml(text.noConversation)}</div>`;
                return;
            }

            messagesBox.innerHTML = messages.map((message) => `
                <div class="internal-chat-message ${message.is_mine ? 'is-mine' : ''}">
                    <div class="internal-chat-message-bubble">
                        <div class="internal-chat-message-author">${message.is_mine ? escapeHtml(text.you) : escapeHtml(threadName.textContent)}</div>
                        <p>${escapeHtml(message.body)}</p>
                        <span>${escapeHtml(message.created_at || '')}</span>
                    </div>
                </div>
            `).join('');

            messagesBox.scrollTop = messagesBox.scrollHeight;
        };

        const setThreadEmptyState = () => {
            emptyState.classList.remove('d-none');
            threadShell.classList.add('d-none');
            state.activeUserId = null;
        };

        const renderThread = (conversation) => {
            emptyState.classList.add('d-none');
            threadShell.classList.remove('d-none');
            threadAvatar.src = conversation.user.avatar_url;
            threadAvatar.alt = conversation.user.name;
            threadName.textContent = conversation.user.name;
            threadEmail.textContent = conversation.user.email;
            renderMessages(conversation.messages || []);
            renderConversations();
        };

        const loadPanelData = async () => {
            const response = await fetch(panelUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                throw new Error('Unable to load chat panel');
            }

            const data = await response.json();
            state.conversations = data.conversations || [];
            state.users = data.users || [];
            updateUnreadBadges(Number(data.unread_count || 0));
            renderUserSelect();
            renderConversations();
            renderDropdown();
        };

        const loadConversation = async (userId) => {
            if (!userId) {
                return;
            }

            state.activeUserId = Number(userId);

            const response = await fetch(replaceUserInUrl(showUrlTemplate, userId), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                return;
            }

            const data = await response.json();
            renderThread(data.conversation);
            await loadPanelData();
        };

        const sendMessage = async () => {
            const body = messageInput.value.trim();

            if (!state.activeUserId || !body) {
                return;
            }

            const response = await fetch(replaceUserInUrl(storeUrlTemplate, state.activeUserId), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ body }),
            });

            if (!response.ok) {
                return;
            }

            messageInput.value = '';
            await loadConversation(state.activeUserId);
        };

        const openPanel = async () => {
            panel.classList.remove('d-none');
            toggle.classList.add('is-open');
            if (!state.conversations.length && !state.users.length) {
                conversationList.innerHTML = `<div class="internal-chat-placeholder">${escapeHtml(text.loading)}</div>`;
            }
            await loadPanelData();
        };

        const closePanel = () => {
            panel.classList.add('d-none');
            toggle.classList.remove('is-open');
        };

        toggle.addEventListener('click', async function () {
            if (panel.classList.contains('d-none')) {
                await openPanel();
                return;
            }

            closePanel();
        });

        closeButton.addEventListener('click', closePanel);

        startButton.addEventListener('click', function () {
            if (!userSelect.value) {
                return;
            }

            openPanel().then(() => loadConversation(userSelect.value));
        });

        searchInput.addEventListener('input', renderConversations);

        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            await sendMessage();
        });

        messageInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        });

        document.querySelectorAll('.chat-open-panel-trigger').forEach((button) => {
            button.addEventListener('click', function () {
                openPanel();
            });
        });

        window.InternalChat = {
            open: openPanel,
            openConversation: function (userId) {
                return openPanel().then(() => loadConversation(userId));
            },
            refresh: loadPanelData,
        };

        setThreadEmptyState();
        loadPanelData();
        state.poller = window.setInterval(async function () {
            await loadPanelData();
            if (state.activeUserId) {
                await loadConversation(state.activeUserId);
            }
        }, 15000);
    });
</script>
