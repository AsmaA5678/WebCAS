const express = require('express');
const port = 3001;
const morgan = require('morgan');
const mongoose = require('mongoose');
const User = require('./models/User.js');
const Activity = require('./models/Activity.js');

const app = express();
app.set('view engine', 'ejs');
app.use(morgan('dev'));
app.use(express.static('styles'));
app.use(express.static('images'));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const dbURI = 'mongodb+srv://user:pass@cluster0.a8hitke.mongodb.net/WEBCAS?retryWrites=true&w=majority';
mongoose.connect(dbURI, {
    useNewUrlParser: true, 
    useUnifiedTopology: true})
    .then((result) => app.listen(port))
    .catch((err) => console.log(err));

app.get('/', (req, res) => {
    res.send('<p>hello</p>');
});

app.get('/membre', async (req, res) => {

    try {
        const users = await User.find();
        const activities = await Activity.find();
        res.render('Membre', { users, activities});
    } catch (err) {
        console.error(err);
    }

});

app.get('/admin', async (req, res) => {

    try {
        const users = await User.find();
        const activities = await Activity.find();
        res.render('Admin', { users, activities});
    } catch (err) {
        console.error(err);
    }

});

app.post('/ajouter-activite', async (req, res) => {

    try {
        const newActivity = new Activity({
            titre: req.body.titre,
            date: req.body.date,
            heure: req.body.heure,
            localisation: req.body.localisation,
            description: req.body.description
        });
        await newActivity.save(); // sauvegarde dans la base de données
        res.redirect('/admin'); // redirection à l'admin 
    } catch (error) {
        console.error(error);
        res.status(500).send('Internal Server Error');
    }

});
