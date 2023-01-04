<style>
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    .chat
    {
        border-radius: 3px;
        background: white;
        border: solid 1px rgba(0,0,0,0.2);
        height: 370px;
        border-bottom: none;
    }

    .chat-body
    {
        height: 320px;
        scroll-behavior: smooth;
        overflow: scroll;
        margin-bottom: 10px;    
    }

    .chat-input
    {

    }

    #chat-input
    {
        border-left: none;
        border-radius: 0;
        border-right: none;
    }
    
    #chat-input:focus{
        outline: none;
    }

</style>
<template>
    <div class="card">
        <div class="card-title">
        </div>
        <div class="card-body">
            <div class="chat">
                <div class="chat-body"></div>
                <div class="chat-input">
                    <input @keyup="sendMessage" type="text" class="form-control shadow-none" id="chat-input" >
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default 
    {
        name: "ChatComponent",

        created()
        {

            const host = 'localhost';
            
            const port = 9090;
            
            const route = '/';

            this.client = new WebSocket(`ws://${host}:${port}${route}`);

            this.client.addEventListener('open', (event) => {
                axios.get(origin + '/messages')
                .then(response => {
                    for(let message of response.data){
                        document.querySelector('.chat-body')
                        .appendChild(
                            this.makeElement(JSON.stringify({
                                user: message.user.name,
                                text: message.text,
                                time: message.time,
                        })))
                    }
                    
                })
                .then(()=>
                {
                    this.client.addEventListener('message', (event) =>{
                        let chatBody = document.querySelector('.chat-body');
                        chatBody.appendChild(this.makeElement(event.data))
                        chatBody.scrollTo(0, chatBody.scrollHeight + 1000);
                    })
                })
            });

            this.client.addEventListener('close', (event) => {
                document.querySelector('.chat-body').innerHTML = ''
            })

            this.client.addEventListener('error', (err) =>{
                console.log(err)
            })
        },

        data()
        {
            return {  
                client: null,
            }
        },

        methods:
        {
            sendMessage(event)
            {
                if(event.keyCode == 13){

                    axios.get(origin + '/login-data').then(response =>{
                        let date = new Date();

                        let message = JSON.stringify({
                            id: response.data.id,
                            user: response.data.user,
                            text: event.target.value,
                            time: date
                        });

                        this.client.send(message);
                        let chatBody = document.querySelector('.chat-body');
                        chatBody.appendChild(this.makeElement(message));
                        chatBody.scrollTo(0, chatBody.scrollHeight + 1000);
                    })
                    .then(() => event.target.value = '');
                }
            },

            makeElement(data)
            {
                let response = JSON.parse(data);

                let date = new Date(response.time);
                let dateString = `${date.getHours()} : ${date.getMinutes()}`;

                let element = document.createElement('div');
                let elementTxt = document.createElement('div');
                let info = document.createElement('div');
                let user = document.createElement('div');

                element.style.left = '6%';
                element.style.right = '4%';
                element.style.margin = '10px';
                element.style.padding = '5px';
                element.style.borderRadius = '3px';
                element.style.border = 'solid 1px rgba(0,0,0,0.2)';

                user.innerText = response.user;
                info.innerText = dateString;
                elementTxt.innerText = response.text;

                elementTxt.style.left = '10%';
                elementTxt.style.margin = '4px';

                user.style.fontSize = '11px';
                user.style.color = 'rgba(0,0,0,0.4)';

                info.style.fontSize = '9px'
                info.style.color = 'rgba(0,0,0,0.2)';

                element.appendChild(user);
                element.appendChild(elementTxt);
                element.appendChild(info);

                return element;
            }
        }
    }
 

</script>