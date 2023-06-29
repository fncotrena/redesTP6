import shortid from 'shortid';
import debug from 'debug';
import { CreateBookDto } from '../dto/create.book.dto';
import { PatchBookDto } from '../dto/patch.user.dto';
import { PutBookDto } from '../dto/put.book.dto';

const log: debug.IDebugger = debug('app:in-memory-dao');

/**
 * NEVER USER THIS CLASS IN REAL LIFE.
 * This class was created to ease the explanation of other topics in the corresponding article.
 * For any real-life scenario, consider using an ODM/ORM to manage your own database in a better way.
 */
class BooksDao {
    books: Array<CreateBookDto> = [];

    constructor() {
        log('Created new instance of BooksDao');
    }

    async addBook(book: CreateBookDto) {
        book.id = shortid.generate();
        this.books.push(book);
        return book.id;
    }

    async getBooks() {
        return this.books;
    }

    async getBooksUserId(idUser:string) {
        const booksByUser = this.books.filter(book => book.user.id === idUser);
        return booksByUser;    }


    async getBookById(bookId: string) {
        return this.books.find((book: { id: string }) => book.id === bookId);
    }
    async getBookByUserId(bookId: string, userId: string) {
        const book = this.books.find((book: { id: string, user: { id: string } }) => book.id === bookId && book.user.id === userId);
        return book;
      }
    
    async putBookById(bookId: string, book: PutBookDto) {
        const objIndex = this.books.findIndex(
            (obj: { id: string }) => obj.id === bookId
        );
        this.books.splice(objIndex, 1, book);
        return `${book.id} updated via put`;
    }

    async patchBookById(userId: string, user: PatchBookDto) {
        const objIndex = this.books.findIndex(
            (obj: { id: string }) => obj.id === userId
        );
        let currentUser = this.books[objIndex];
        const allowedPatchFields = [
            'password',
            'firstName',
            'lastName',
            'permissionLevel',
        ];
        for (let field of allowedPatchFields) {
            if (field in user) {
                // @ts-ignore
                currentUser[field] = user[field];
            }
        }
        this.books.splice(objIndex, 1, currentUser);
        return `${user.id} patched`;
    }

    async removeBookById(userId: string) {
        const objIndex = this.books.findIndex(
            (obj: { id: string }) => obj.id === userId
        );
        this.books.splice(objIndex, 1);
        return `${userId} removed`;
    }




    
}

export default new BooksDao();
