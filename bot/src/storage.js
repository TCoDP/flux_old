import { readFileSync, writeFileSync, existsSync, mkdirSync } from 'node:fs';
import { dirname } from 'node:path';

/**
 * Minimal file-backed StorageAdapter for grammY sessions.
 * Keeps the whole map in memory and persists to a JSON file on every write.
 * Adequate for small/medium bots; swap for Redis at scale.
 */
export class FileAdapter {
    constructor(path) {
        this.path = path;
        this.data = {};

        const dir = dirname(path);
        if (!existsSync(dir)) mkdirSync(dir, { recursive: true });

        if (existsSync(path)) {
            try {
                this.data = JSON.parse(readFileSync(path, 'utf8'));
            } catch {
                this.data = {};
            }
        }
    }

    read(key) {
        return this.data[key];
    }

    write(key, value) {
        this.data[key] = value;
        this.persist();
    }

    delete(key) {
        delete this.data[key];
        this.persist();
    }

    persist() {
        try {
            writeFileSync(this.path, JSON.stringify(this.data, null, 2));
        } catch (error) {
            console.error('[storage] Failed to persist sessions:', error.message);
        }
    }
}
