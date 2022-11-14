export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.type === 'admin';
    }

    isUser(){
        return this.user.type === 'user';
    }
    isRecruiter(){
        return this.user.type === 'recruiter';
    }

    isAdminOrUserOrRecruiter(){
        if(this.user.type === 'user' || this.user.type === 'admin' || this.user.type === 'recruiter'){
            return true;
        }
    }
}

