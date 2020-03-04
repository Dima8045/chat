<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-1">
                    <div class="card-header">Socket Chat</div>
                        <div class="form-group">
                            <textarea rows="10" class="form-control" readonly>{{ messages.join('\n')}}</textarea>
                        </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter message"  v-model="message">
                        <div class="input-group-append">
                            <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
      data() {
        return {
          messages: [],
          message: ''
        }
      },
      props: ['room'],
      mounted() {
        console.log(this.room)
        window.Echo.private('room.' + this.room.id)
          .listen('Message', (data) => {
            this.messages.push(data.data.message)
            console.log(data.data)
          })
      },
      methods: {
        sendMessage() {
            axios.post('/send-message', {message: this.message, roomId: this.room.id})
        }
      }
    }
</script>
