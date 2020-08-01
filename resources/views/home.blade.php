@extends('layouts.dashboard')

@section('content')

        @include('components.earningSummary')

            @if(!$user->active && $user->matched)
            
                @include('components.activation')

            @elseif($user->active) 

                @if ($singlePayment) 
                  @include('components.investment')

                @elseif($paymentGroup)
                    @include('components.groupPayment')        

                @elseif($receiveGroup)
                    @include('components.receiveGroup')

                @elseif($singleReceive)
                    @include('components.singleReceive')

                @elseif($paid)
                    @include('components.confirmPayment')

                @elseif($waitMessage)
                    @include('components.waitMessage')

                @elseif($currentInvestments)
                    @include('components.currentInvestments')

                @elseif($activeInvestments)
                    @include('components.activeInvestments')

                @else
                   @include('components.noInvestment')
                @endif
                
            @endif
              
    <script>
        function confirmPayment(id)
        {
            event.preventDefault();
            var formElement = document.getElementById(id);
            var confirmResponse = confirm("Please confirm your action. It cannot be reversed");
            if(confirmResponse){
                formElement.submit()
            }
        }
        // $(document).ready(function(){
        //     $("#confirm").on('click', function(){
        //         event.preventDefault()
        //         var confirmResponse = confirm('Are you sure you want to confirm payment?')
        //         if(confirmResponse){
        //             $("#confirmForm").submit();
        //         }
        //     });

        //     $("#confirm2").on('click', function(){
        //         event.preventDefault()
        //         var confirmResponse = confirm('Are you sure you want to confirm payment?')
        //         if(confirmResponse){
        //             $("#confirmForm2").submit();
        //         }
        //     });
        // })
    </script>
    @if ($investment)
        <script>
            (function CountDownTimer() {
                // Set the date we're counting down to
                var countDownDate = new Date('{{ $date->format("M j, Y H:i:s") }}').getTime();

                // Update the count down every 1 second
                var x = setInterval(function () {
                    // Get today's date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                    );
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Output the result in an element with id="demo"
                    document.getElementById("demo__countdown").innerHTML =
                    days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                    // If the count down is over, write some text
                    if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo__countdown").innerHTML = "EXPIRED";
                    }
                }, 1000);
            })();
        </script>
    @endif
    @if ($paymentGroup)
        @foreach ($paymentGroup as $item)
            <script>
                var id = "{{$item->id}}"
                (function CountDownTimer(id) {
                    // Set the date we're counting down to
                    var countDownDate = new Date('{{ getCarbonInstance($item->mature_date)->format("M j, Y H:i:s") }}').getTime();

                    // Update the count down every 1 second
                    var x = setInterval(function () {
                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;

                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor(
                        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                        );
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Output the result in an element with id="demo"
                        document.getElementById(id).innerHTML =
                        days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                        // If the count down is over, write some text
                        if (distance < 0) {
                        clearInterval(x);
                        document.getElementById(id).innerHTML = "EXPIRED";
                        }
                    }, 1000);
                })();
            </script> 
        @endforeach
    @endif
@endsection