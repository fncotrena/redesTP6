import express from 'express';
import bookService from '../services/books.service';
import debug from 'debug';

const log: debug.IDebugger = debug('app:users-controller');
class BooksMiddleware {

    async validateRequiredBookBodyFields(
        req: express.Request,
        res: express.Response,
        next: express.NextFunction
    ) {
        if (req.body && req.body.title && req.body.autor) {
            next();
        } else {
            res.status(400).send({
                error: `Missing required fields title and author`,
            });
        }
    }
    async validatePathIdBookNotEmpty(
        req: express.Request,
        res: express.Response,
        next: express.NextFunction
    ) {
        if (req.params.bookId!="") {
            next();
        } else {
            res.status(400).send({
                error: `Missing required fields id`,
            });
        }
    }

    


    async validateBookExists(
        req: express.Request,
        res: express.Response,
        next: express.NextFunction
    ) {
        const user = await bookService.readById(req.params.bookId);
        if (user) {
            next();
        } else {
            res.status(404).send({
                error: `Book ${req.params.bookId} not found`,
            });
        }
    }

    async extractUserId(
        req: express.Request,
        res: express.Response,
        next: express.NextFunction
    ) {
        req.body.id = req.params.userId;
        next();
    }
}

export default new BooksMiddleware();
