# pushit
Laravel push notification manager. Full backend management of subscriptions and notification sending to subscribers.

## Installation

To get started with pushit just run in your Laravel application:

    composer require kmak/pushit

In your views that you wish to notify the user that subscription for notifications is available simply add:

    @include('kmak/pushit::subscribe')
