function attachments_path($path='')
{
    return ('files'.($path ? DIRECTORY_SEPARATOR.$path : $path));
}
