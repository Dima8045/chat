<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-1">
                    <div class="card-header bg-info"><h4>Socket Chat</h4></div>
                    <div class="cart-body">
                        <div ref="messages" id="messages" class="bg-light">
                            <ul class="list-group list-group-flush">
                                <li v-for="msg in messages" class="border-bottom border-secondary">
                                    <b>{{msg.user.name}} </b><span class="text-secondary small">({{ msg.message.timestamp }})</span><br>
                                    <span class="ml-5">{{ msg.message.message }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" placeholder="Enter message"  v-model="message" @keydown="actionUser" @keypress.enter="sendMessage">
                        <div class="input-group-append">
                            <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Send</button>
                        </div>
                    </div>
                    <span v-if="isActive">{{ isActive.name }} typing...</span>
                </div>
            </div>
            <div class="col-md-4">
                <ul>
                    <li v-for="user in activeUsers">{{ user.name }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style>
    .cart-body {
        height: 100%;
        overflow: hidden;
    }
    #messages {
        height: 300px;
        overflow-y: auto;
        overflow-x: auto;
    }
</style>

<script>
  export default {
    data() {
      return {
        messages: [],
        message: '',
        isActive: false,
        typingTime: false,
        activeUsers: [],
      }
    },


    props: [
      'room',
      'user'
    ],
    computed: {
      channel() {
        return window.Echo.join('room.' + this.room.id)
      }
    },
    mounted() {
      this.channel
        .here((users) => {
          this.activeUsers = users
        })
        .joining((user) => {
          this.activeUsers.push(user)
        })
        .leaving((user) => {
          this.activeUsers.splice(this.activeUsers.indexOf(user), 1)
        })
        .listen('Message', ({data}) => {
          console.log(data)
          this.messages.push(data)
          this.message = ''
          this.isActive = false
          setTimeout(() => this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight, 0)
        })
        .listenForWhisper('typing', (e) => {
          this.isActive = e
          if (this.typingTime ) clearTimeout(this.typingTime)
          this.typingTime = setTimeout(() => {
            this.isActive = false
          }, 2000)
        })
    },
    methods: {
      sendMessage() {
        if (this.message.trim().length > 0) {
          axios.post('/send-message', { message: this.message, roomId: this.room.id })
        }
      },
      actionUser() {
        this.channel
          .whisper('typing', {
            name: this.user.name
          })
      }
    }
  }
</script>