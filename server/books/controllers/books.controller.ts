import express from 'express';
import booksService from '../services/books.service';
import argon2 from 'argon2';
import debug from 'debug';
import usersService from '../../users/services/users.service';

const log: debug.IDebugger = debug('app:users-controller');
class BooksController {
    async listBooks(req: express.Request, res: express.Response) {
        const userId = req.params.userId;
        console.log('paramet',userId)

        const books = await booksService.listByUserId(100, 0,userId);
        res.status(200).send(books);
    }


    async createBook(req: express.Request, res: express.Response) {
        const userId = req.params.userId;
        const user = await usersService.readById(userId)
        const book=req.body;
        book.user=user;
        const bookId = await booksService.create(book);
        console.log(bookId)
        res.status(200).send({ id: bookId });
    }
    async getBookById(req: express.Request, res: express.Response) {
        const userId = req.params.userId;
        const bookId = req.params.bookId;
        console.log('userid y book id',userId,bookId)
        const book = await booksService.getById(bookId,userId);
        res.status(200).send(book);   
     }

    async patch(req: express.Request, res: express.Response) {
        const userId = req.params.userId;
        const user = await usersService.readById(userId)
        const book=req.body;
        book.user=user;
        log(await usersService.patchById(req.body.id, book));
        res.status(200).send();
    }

    async put(req: express.Request, res: express.Response) {
        const userId = req.params.userId;
        const bookId = req.params.bookId;
        const user = await usersService.readById(userId)
        const book=req.body;
        book.user=user;
        console.log(await booksService.putById(bookId, book));
        res.status(200).send();
    }

    async removeBook(req: express.Request, res: express.Response) {
        const userId = req.params.userId;
        const bookId = req.params.bookId;
        const book = await booksService.getById(bookId, userId);
      
        if (book) {
          await booksService.deleteByUserId(book.id);
          res.status(200).send();
        } else {
          res.status(404).send({ error: 'Book not found' });
        }
      }
      
}
export default new BooksController();
