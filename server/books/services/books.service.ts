import { CRUD } from '../../common/interfaces/crud.interface';
import { CreateBookDto } from '../dto/create.book.dto';
import { PutBookDto } from '../dto/put.book.dto';
import { PatchBookDto } from '../dto/patch.user.dto';
import booksDao from '../daos/books.dao';

class BooksService implements CRUD {
    async create(resource: CreateBookDto) {
        console.log('usuario a crear :',resource)
        return booksDao.addBook(resource);
    }

    async deleteById(id: string) {
        return booksDao.removeBookById(id);
    }

    async deleteByUserId(bookId:string) {
        return booksDao.removeBookById(bookId);
    }

    async list(limit: number, page: number) {   
        return booksDao.getBooks();
    }

    async listByUserId(limit: number, page: number,userId:string) {
        return booksDao.getBooksUserId(userId);
    }
    async patchById(id: string, resource: PatchBookDto): Promise<any> {
        return booksDao.patchBookById(id, resource);
    }

    async putById(id: string, resource: PutBookDto): Promise<any> {
        return booksDao.putBookById(id, resource);
    }

    async readById(id: string) {
        return booksDao.getBookById(id);
    }

    async getById(idBook: string,userId:string) {
        return booksDao.getBookByUserId(idBook,userId);
    }
}

export default new BooksService();
