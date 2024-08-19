<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    @if(isset($checkout))
        {{ $checkout }}
    @else
        <p>Checkout information is not available.</p>
    @endif
</body>
</html>
