<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">{{welcome}}</div>
                    
                    <div class="card-body">
                      <form @submit.prevent="addTodo">
                       <div class="form-group">
                           <input type="text" required v-model="form.title" class="form-control" placeholder="Title">
                       </div>
                        <input type="submit" value="Add" class="btn btn-primary ">
                        </form>
                        
                    </div>
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Is completed</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <template v-if="!todos.length">
                                <tr>
                                    <td colspan="4" class="text-center">No Data</td>
                                </tr>
                             </template>
                              <template v-else>
                                <tr v-for="todo in todos" :key="todo.id">
                                    <td>{{todo.title}}</td>
                                     <td>
                                         
                                         <input type="checkbox" class="form-control" @click="completeTodo(todo.id)" v-model="todo.is_completed" > 
                                     </td>
                                     <td> <button @click="deleteTodo(todo.id)" class="btn btn-danger">Delete</button> <button @click="editTodo(todo)" class="btn btn-primary">Edit</button> </td>
                                </tr>
                             </template>
                           
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validate from 'validate.js'
import { constants } from 'crypto';
    export default {
        name: 'home',
        data(){
            return {
                form: {
                    id:'',
                    title:'',
                },
                edit:false
            };
        },
        mounted(){
            this.$store.dispatch('getTodos');
        },
        methods: {
           
            addTodo() {
                 if(this.edit===false){
              axios.post('/api/todos/new',this.$data.form)
              .then((response)=>{
                  alert("todo added");
                  this.form.title='';
                  this.$store.dispatch('getTodos');
              })
               .catch(err=>console.log(err))
            console.log(this.$data.form)
                 }else{
                     //update todos
                     axios.put('/api/todos/',this.$data.form)
              .then((response)=>{
                  alert("todo updated");
                  this.form.title='';
                  this.$store.dispatch('getTodos');
              })
               .catch(err=>console.log(err))
            console.log(this.$data.form)
                 }

            },
           
            deleteTodo(id){
                if(confirm("are you sure??")){
                   axios.delete(`/api/todo/${id}`)
                   .then((response)=>{
                       alert("Todo is deleted");
                        this.$store.dispatch('getTodos');
                   })
                   .catch(err=>console.log(err))

                }
            },
            editTodo(todo){
                this.edit=true;
                this.form.title = todo.title;
                this.form.id = todo.id;
            },
            completeTodo(id)
            {
               axios.put(`/api/todos/complete/${id}`)
              .then((response)=>{
                 
                  this.$store.dispatch('getTodos');
              })
               .catch(err=>console.log(err))
            console.log(this.$data.form)
            }
           
        },
        computed: {
            welcome() {
                return this.$store.getters.AppTitle;
            },
            todos(){
                return this.$store.getters.todos;
            }
        }
    }
</script>
