export default class WebSocketClient
{
    _client;

    _elementRoot;

    server = 'localhost';

    port = 9090;

    route = '/';


    constructor()
    {
        this._client = new WebSocket(`ws://${this.server}:${this.port}${this.route}`);
    }

    connect()
    {
        this._client.onopen = (event) => {
            this._client.addEventListener('message', (event) =>{
                console.log(event.data);

                this.addMessage(event.data)
            
            });
            console.log('connected')
        };
    
        this._client.onclose = (event) => {
            
            console.log('connection close')
        };

        this._client.onerror = (error) => console.log(error);

        
    }

    addMessage(data)
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

        this._elementRoot.appendChild(element);
        
    }

    send(message)
    {
       return this.getClient(message).send(message);
    }

    root(name)
    {
        this._elementRoot = document.querySelector('.' + name);
    }   

    getClient()
    {
        return this._client;
    }

    setClient(client)
    {
        this._client = client
    }
}