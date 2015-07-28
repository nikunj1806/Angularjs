//----------------- Contact -----------------------//
app.service('ContactService', function () {
    //to create unique contact id
    var uid = 1;

    //contacts array to hold list of all contacts
    var contacts = [{
            id: 0,
            'name': 'nikunj',
            'email': 'nick@gmail.com',
            'phone': '123-2343-44'
        }];

    //save method create a new contact if not already exists
    //else update the existing object
    this.save = function (contact) {
        if (contact.id == null) {
            //if this is new contact, add it in contacts array
            contact.id = uid++;
            contacts.push(contact);
        } else {
            //for existing contact, find this contact using id
            //and update it.
            for (i in contacts) {
                if (contacts[i].id == contact.id) {
                    contacts[i] = contact;
                }
            }
        }

    }

    //simply search contacts list for given id
    //and returns the contact object if found
    this.get = function (id) {
        for (i in contacts) {
            if (contacts[i].id == id) {
                return contacts[i];
            }
        }

    }

    //iterate through contacts list and delete 
    //contact if found
    this.delete = function (id) {
        for (i in contacts) {
            if (contacts[i].id == id) {
                contacts.splice(i, 1);
            }
        }
    }

    //simply returns the contacts list
    this.list = function () {
        return contacts;
    }
});


//----------------- Contact -----------------------//
app.service('CategoryService', function () {
    //to create unique contact id
    var uid = 1;

    //contacts array to hold list of all contacts
    var categories = [{
            id: 0,
            'name': 'Tobacco',
            'description': 'Tobbaco Category',
            
        }];

    //save method create a new contact if not already exists
    //else update the existing object
    this.save = function (category) {
        if (category.id == null) {
            //if this is new contact, add it in contacts array
            category.id = uid++;
            categories.push(category);
        } else {
            //for existing contact, find this contact using id
            //and update it.
            for (i in categories) {
                if (categories[i].id == category.id) {
                    categories[i] = category;
                }
            }
        }

    }

    //simply search contacts list for given id
    //and returns the contact object if found
    this.get = function (id) {
        for (i in categories) {
            if (categories[i].id == id) {
                return categories[i];
            }
        }

    }

    //iterate through contacts list and delete 
    //contact if found
    this.delete = function (id) {
        for (i in categories) {
            if (categories[i].id == id) {
                categories.splice(i, 1);
            }
        }
    }

    //simply returns the contacts list
    this.list = function () {
        return categories;
    }
});