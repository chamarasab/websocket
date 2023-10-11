using System;
using System.Net;
using System.Net.WebSockets;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace sms
{
    class Program
    {
        private static async Task HandleWebSocketClientAsync(HttpListenerContext context)
        {
            if (context.Request.IsWebSocketRequest)
            {
                HttpListenerWebSocketContext webSocketContext = await context.AcceptWebSocketAsync(null);

                WebSocket webSocket = webSocketContext.WebSocket;
                Console.WriteLine("WebSocket connection established.");

                try
                {
                    byte[] buffer = new byte[1024];
                    while (webSocket.State == WebSocketState.Open)
                    {
                        WebSocketReceiveResult result = await webSocket.ReceiveAsync(new ArraySegment<byte>(buffer), CancellationToken.None);
                        if (result.MessageType == WebSocketMessageType.Text)
                        {
                            string receivedMessage = Encoding.UTF8.GetString(buffer, 0, result.Count);
                            Console.WriteLine($"Received JSON: {receivedMessage}");

                            // You can parse the received JSON here and perform actions accordingly
                            // For example, if you expect a JSON object with keys like 'id', 'reference', etc.
                            // You can deserialize it into a C# object using a library like Newtonsoft.Json

                            // Example:
                            // YourDataModel data = JsonConvert.DeserializeObject<YourDataModel>(receivedMessage);

                            // Now, 'data' contains the received data, and you can process it as needed.
                        }
                    }
                }
                catch (WebSocketException)
                {
                    // Handle WebSocket exceptions here
                }
                finally
                {
                    if (webSocket.State == WebSocketState.Open)
                    {
                        await webSocket.CloseAsync(WebSocketCloseStatus.NormalClosure, "Connection closed by the server", CancellationToken.None);
                    }
                    webSocket.Dispose();
                }
            }
        }

        static async Task Main(string[] args)
        {
            HttpListener listener = new HttpListener();
            listener.Prefixes.Add("http://localhost:8080/"); // Replace with your desired server address
            listener.Start();
            Console.WriteLine("Server listening on http://localhost:8080/");

            while (true)
            {
                HttpListenerContext context = await listener.GetContextAsync();
                if (context.Request.IsWebSocketRequest)
                {
                    await HandleWebSocketClientAsync(context);
                }
                else
                {
                    // Handle other HTTP requests here if needed
                }
            }
        }
    }
}
