<x-mail::message>
# Order Delivery Confirmation

Hello **{{ $order->name }}**,

A rider is ready to deliver your order **#{{ $order->id }}**. Please provide the following OTP to the rider to confirm the delivery:

<x-mail::panel>
**{{ $otp }}**
</x-mail::panel>

This OTP will expire in 10 minutes.

If you did not expect this delivery, please contact our support team immediately.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
