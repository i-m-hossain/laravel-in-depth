import Echo from 'laravel-echo';
import './bootstrap';
import '../css/app.css'; 
const form = document.getElementById('form');  
const inputMessage = document.getElementById('input-message')
const listMessage = document.getElementById('list-messages')
form.addEventListener("submit", e=>{
    e.preventDefault();
    const response = axios.post('/chat-message', {
        message: inputMessage.value
    }).then(({data, status})=> {
        if(status === 200){
            inputMessage.value=""
        }
    }).catch(error=> window.alert(error.code));
    
    
})
/**
 * public channel 
 * */ 
// const channel = window.Echo.channel('public.chat.1')

/**
 * private channel
 */
const channel = window.Echo.private('private.chat.1')
channel.subscribed(()=>{
    console.log('subscribed');
}).listen('.chat-message', e=>{
    const msg=e.message;
    const li = document.createElement('li')
    li.textContent = msg
    listMessage.append(li)
})