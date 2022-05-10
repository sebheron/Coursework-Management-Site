class RegisterForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {value: ''};
        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }
    
    handleChange(event)
    { 
        switch (event.target.name) {
            case "name":
                this.setState({name:event.target.value});
                this.setState({name_changed:true});
                break;
            case "phone":
                this.setState({phone:event.target.value});
                this.setState({phone_changed:true});
                break;
            case "email":
                this.setState({email:event.target.value});
                this.setState({email_changed:true});
                break;
            case "password":
                this.setState({password:event.target.value});
                this.setState({password_changed:true});
                break;
        }
    }

    handleSubmit(event) {
        let name_error;
        let phone_error;
        let email_error;
        let password_error;

        if (this.state.name_changed) {
            name_error = this.getNameErrors(this.state.name);
        }
        if (this.state.phone_changed) {
            phone_error = this.getNumberErrors(this.state.phone);
        }
        if (this.state.email_changed) {
            email_error = this.getEmailErrors(this.state.email);
        }
        if (this.state.password_changed) {
            password_error = this.getPasswordErrors(this.state.password);
        }

        if (!this.state.name_changed
            || !this.state.phone_changed
            || !this.state.email_changed
            || !this.state.password_changed
            || name_error != null
            || phone_error != null
            || email_error != null
            || password_error != null) {
            event.preventDefault();
        }
    }

    parseErrors(errors) {
        let error_box;
        if (errors != "") {
            error_box = (<div className="error-text">{
                errors.split("\n").map((i,n) => {
                return <p>{i}</p>;
            })}</div>);
        }
        return error_box;
    }

    getNameErrors(name) {
        let errors = "";
        if (name.length < 1) {
            errors += "• Name must be at least 1 character long.\n";
        }
        if (name.match(/[^a-zA-Z\ ]/)) {
            errors += "• Name must only contain letters.\n";
        }
        return this.parseErrors(errors);
    }

    getNumberErrors(number) {
        let errors = "";
        if (!number.match(/^(\+44\s?7\d{3}|\(?07\d{3}\)?|\(?01\d{3}\)?)\s?\d{3}\s?\d{3}$/)) {
            errors += "• Phone number must be in the valid UK format.\n";
        }
        return this.parseErrors(errors);
    }

    getEmailErrors(email) {
        let errors = "";
        if (!email.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/)) {
            errors += "• Email must be in the valid format.\n";
        }
        return this.parseErrors(errors);
    }

    getPasswordErrors(password) {
        let errors = "";
        if (password.length < 4) {
            errors += "• Password must be at least 4 character long.\n";
        }
        if (password.length >= 30) {
            errors += "• Password must be less than 30 characters long.\n";
        }
        if (!password.match(/[a-z]/)) {
            errors += "• Password must contain at least 1 lowercase letter.\n";
        }
        if (!password.match(/[A-Z]/)) {
            errors += "• Password must contain at least 1 uppercase letter.\n";
        }
        if (!password.match(/[0-9]/)) {
            errors += "• Password must contain at least 1 number.\n";
        }
        if (!password.match(/[^a-zA-Z0-9]/)) {
            errors += "• Password must contain at least 1 special character.\n";
        }
        return this.parseErrors(errors);
    }

    render(){
        let name_error;
        let phone_error;
        let email_error;
        let password_error;

        if (this.state.name_changed) {
            name_error = this.getNameErrors(this.state.name);
        }
        if (this.state.phone_changed) {
            phone_error = this.getNumberErrors(this.state.phone);
        }
        if (this.state.email_changed) {
            email_error = this.getEmailErrors(this.state.email);
        }
        if (this.state.password_changed) {
            password_error = this.getPasswordErrors(this.state.password);
        }

        let disabled = !this.state.name_changed
            || !this.state.phone_changed
            || !this.state.email_changed
            || !this.state.password_changed
            || name_error != null
            || phone_error != null
            || email_error != null
            || password_error != null;

        return (
            <div className="panel-block w22">
                <h1 className="center-text">Register</h1>
                <form onSubmit={this.handleSubmit} method="POST" action="php/register.php" novalidate>
                    <input className="input-box" name="name" type="text" onChange={this.handleChange} placeholder="Name" maxlength="30" required/>
                    {name_error}
                    <input className="input-box" name="phone" type="text" onChange={this.handleChange} placeholder="Phone Number" maxlength="30" required/>
                    {phone_error}
                    <input className="input-box" name="email" type="text" onChange={this.handleChange} placeholder="Email" maxlength="30" required/>
                    {email_error}
                    <input className="input-box" name="password" type="password" onChange={this.handleChange} placeholder="Password" maxlength="30" required/>
                    {password_error}
                    <button disabled={disabled} className="embossed-button fill-button" type="submit">Register</button>
                </form>
            </div>
        );
    }
}

ReactDOM.render(<RegisterForm/>, document.getElementById('root'));