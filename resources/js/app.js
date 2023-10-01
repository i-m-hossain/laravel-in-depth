import Echo from 'laravel-echo';
import './bootstrap';
const channel = Echo.channel('public.playground.1')
channel.subscribe(()=>{
    console.log('subscribed');
})